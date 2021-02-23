<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class UsersImportWithHeadingRow extends UsersImport implements WithHeadingRow
{
    /**
     * ClassImportWithHeadingRow constructor.
     * @param string $encode
     */
    public function __construct(string $encode)
    {
        parent::__construct($encode);
        HeadingRowFormatter::default('none');
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '系年班代碼' => 'required',
            '系年班簡稱' => 'required',
            '學號' => 'required|numeric|unique:users,username',
            '姓名' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return ['學號' => 'username'];
    }
}
