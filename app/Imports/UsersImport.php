<?php

namespace App\Imports;

use App\Models\DepartmentClass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithCustomCsvSettings, WithValidation
{
    use Importable;

    /**
     * Reader encode
     * @var string
     */
    private string $encode;

    /**
     * UsersImport constructor.
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
        $uname = trim($row['姓名'] ?? $row[3]);
        $uid = trim($row['學號'] ?? $row[2]);
        $cid = trim($row['系年班代碼'] ?? $row[0]);

        Log::info("Importing\n  cid -> $cid\n  uid -> $uid\n  uname -> $uname");

        return new User([
            'name' => $uname,
            'username' => $uid,
            'email' => $uid . '@gms.tku.edu.tw',
            'password' => Hash::make(substr($uid, -6)),
            'role' => User::STUDENT,
            'class_id' => DepartmentClass::where('class_id', $cid)->first()->id,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '0' => 'required',
            '1' => 'required',
            '2' => 'required|numeric|unique:users,username',
            '3' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return ['2' => 'username'];
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
