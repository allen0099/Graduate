<?php

namespace App\Http\Controllers;

use App\Imports\ClassImport;
use App\Imports\ClassImportWithHeadingRow;
use App\Imports\UsersImportWithHeadingRow;
use App\Imports\UsersImport;
use App\Models\DepartmentClass;
use App\Models\OldClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function uploadStudentList(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'mimes:csv,txt', 'max:5000'],
        ]);

        $path = $request->file('csv_file')->store('', 'public');
        $fp = Storage::disk('public')->get($path);

        Log::info('Upload started!');

        mb_detect_order('ASCII,UTF-8,BIG-5');
        $encode = mb_detect_encoding($request->file('csv_file')->getContent());

        Log::info("Encoding: $encode");

        $firstLine = preg_split('/\r\n|\r|\n/', $fp)[0];
        $convertedLine = mb_convert_encoding($firstLine, 'UTF-8', $encode);
        $check = str_contains($convertedLine, '系年班代碼');

        Log::info("First Line: $check");
        Log::info('Clear started!');

        DepartmentClass::all()
            ->each(function ($origin_data) {
                $oc = OldClass::where('class_id', $origin_data->class_id)->first();

                if (!is_null($oc)) {
                    $oc->delete();
                }

                $nc = $origin_data->replicate();
                $nc->setTable('old_classes');
                $nc->save();

                $origin_data->delete();
            });

        Log::info('Clear ended!');

        if ($check) {
            Excel::import(new ClassImportWithHeadingRow($encode), $path, 'public');
            Excel::import(new UsersImportWithHeadingRow($encode), $path, 'public');
        } else {
            Excel::import(new ClassImport($encode), $path, 'public');
            Excel::import(new UsersImport($encode), $path, 'public');
        }

        return response()->noContent();
    }

    public function updateAdminStamp(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);

        $user = User::find(Auth::id());
        $disk = Storage::disk('picture');

        if ($disk->exists($user->stamp)) {
            $disk->delete($user->stamp);
        }

        $filename = $request->file('image')->store('', 'picture');
        $user->stamp = $filename;
        $user->save();

        return response()->noContent();
    }

    public function searchUser(Request $request)
    {
        $search = $request->search;

        if (!is_null($search)) {
            $find_user = User::where('username', $search);

            if ($find_user->count() === 0) {
                return abort(404);
            }

            $user = $find_user->first();

            if (Auth::user()->isRole(User::STUDENT)) {
                if (!is_null($user->set)) {
                    unset($user->set->student);
                }

                return $user->makeHidden(array_keys($user->toArray()))->makeVisible(['name', 'username', 'school_class', 'set', 'filled_pay_form']);
            } else if (Auth::user()->isRole(User::ADMIN)) {
                if (!is_null($user->set)) {
                    unset($user->set->student);
                }
                return $user;
            }
            return abort(403);
        }
        return abort(404);
    }
}
