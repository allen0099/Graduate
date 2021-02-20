<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ClassImportWithHeadingRow extends ClassImport implements WithHeadingRow
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
