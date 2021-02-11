<?php

namespace App\Imports;

use App\Models\DepartmentClass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class UsersImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    use Importable;

    private string $encode;

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
        $uname = $row['姓名'];
        $uid = $row['學號'];
        $cid = $row['系年班代碼'];

        return new User([
            'name' => $uname,
            'username' => $uid,
            'email' => $uid . '@gms.tku.edu.tw',
            'password' => Hash::make(substr($uid, 0, 6)),
            'role' => User::STUDENT,
            'class_id' => DepartmentClass::where('class_id', $cid)->first()->id,
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => $this->encode,
        ];
    }
}
