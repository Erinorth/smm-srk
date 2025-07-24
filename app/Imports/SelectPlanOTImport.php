<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;

class SelectPlanOTImport implements WithMultipleSheets
{
    use Importable;

    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        return [
            'Import' => new PlanOTImport($this->id),
        ];
    }
}
