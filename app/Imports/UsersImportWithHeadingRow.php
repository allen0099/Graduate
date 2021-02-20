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
}
