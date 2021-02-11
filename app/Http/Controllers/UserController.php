<?php

namespace App\Http\Controllers;

use App\Imports\ClassImport;
use App\Imports\UsersImport;
use App\Models\DepartmentClass;
use App\Models\OldClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        mb_detect_order('ASCII,UTF-8,BIG-5');
        $encode = mb_detect_encoding($request->file('csv_file')->getContent());

        Excel::import(new ClassImport($encode), public_path('storage') . '/' . $path);
        Excel::import(new UsersImport($encode), public_path('storage') . '/' . $path);

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
            }

            return $user;
        }
        return abort(404);
    }
}
