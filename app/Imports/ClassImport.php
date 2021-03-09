<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\DepartmentClass;
use App\Models\OldClass;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ClassImport implements ToModel, WithCustomCsvSettings
{
    use Importable;

    /**
     * Reader encode
     * @var string
     */
    private string $encode;

    /**
     * ClassImport constructor.
     * @param string $encode
     */
    public function __construct(string $encode)
    {
        $this->encode = $encode;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cid = trim($row['系年班代碼'] ?? $row[0]);
        $cname = trim($row['系年班簡稱'] ?? $row[1]);

        Log::info("[Log::NewStudentImporting]", [
            'cid' => $cid,
            'cname' => $cname,
        ]);

        if (!is_null(DepartmentClass::where('class_id', $cid)->first()))
            return null;

        $department = Department::firstOrCreate(
            ['department_id' => substr($cid, 0, 4)],
            // regex remove (?:(?:(?:在職|碩士|碩專)班)|[ＡＢＣＤＥＦＧ]|[一二三四五六七八九]|進學班?)
            ['name' => substr($cname, 0, 6)]
        );

        $old = OldClass::where('class_id', $cid)->firstOrCreate(
            ['class_id' => $cid],
            ['department_id' => $department->id, 'class_name' => $cname]
        );

        return new DepartmentClass([
            'department_id' => $department->id,
            'class_id' => $cid,
            'class_name' => $cname,
            'default_color' => $old->default_color,
        ]);
    }

    /**
     * @return array
     */
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => $this->encode,
        ];
    }
}
