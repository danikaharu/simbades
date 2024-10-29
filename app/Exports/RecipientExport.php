<?php

namespace App\Exports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecipientExport implements WithMultipleSheets
{

    protected $year;

    public function __construct($year)
    {
        $this->year = $year;
    }

    public function sheets(): array
    {
        $sheets = [];

        $assistances = Assistance::all();

        foreach ($assistances as $assistance) {
            $sheets[] = new AssistanceSheetExport($assistance->id, $assistance->alias, $this->year); // ID dan nama bantuan
        }

        return $sheets;
    }
}
