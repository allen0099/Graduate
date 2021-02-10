<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\DepartmentClass;
use App\Models\OldClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ClassImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cid = $row['系年班代碼'];
        $cname = $row['系年班簡稱'];

        if (!is_null(DepartmentClass::where('class_id', $cid)->first()))
            return null;

        $department = Department::where('department_id', substr($cid, 0, 4))->first();

        $old = OldClass::where('class_id', $cid)->first();

        if (!is_null($department)) {
            return new DepartmentClass([
                'department_id' => $department->id,
                'class_id' => $cid,
                'class_name' => $cname,
                'default_color' => (is_null($old))
                    ? null
                    : $old->default_color,
            ]);
        }

        return new Department([
            'department_id' => substr($cid, 0, 4),
            // regex remove (?:(?:(?:在職|碩士|碩專)班)|[ＡＢＣＤＥＦＧ]|[一二三四五六七八九]|進學班?)
            'name' => substr($cname, 0, 6),
        ]);
    }

    public function rules(): array
    {
        return [
            '姓名' => 'required',
            '學號' => 'required|numeric',
            '系年班代碼' => 'required',
            '系年班簡稱' => 'required',
        ];
    }
}
