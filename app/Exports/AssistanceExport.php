<?php

namespace App\Exports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AssistanceExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];
        $assistances = Assistance::all();

        foreach ($assistances as $assistance) {
            $sheets[] = new DetailAssistanceExport($assistance->id, $assistance->alias);
        }

        return $sheets;
    }
}
