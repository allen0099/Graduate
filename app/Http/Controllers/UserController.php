<?php

namespace App\Http\Controllers;

use App\Imports\ClassImport;
use App\Imports\UsersImport;
use App\Models\DepartmentClass;
use App\Models\OldClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function uploadStudentList(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'mimes:csv,txt', 'max:5000'],
        ]);

        $path = $request->file('csv_file')->store('', 'public');

        OldClass::all()
            ->each(function ($_class) {
                $_class->delete();
            });

        DepartmentClass::all()
            ->each(function ($origin_data) {
                $nc = $origin_data->replicate();
                $nc->setTable('old_classes');
                $nc->save();

                $origin_data->delete();
            });

        Excel::import(new ClassImport, public_path('storage') . '/' . $path);
        Excel::import(new UsersImport, public_path('storage') . '/' . $path);

        return response()->noContent();
    }
}
