<?php

namespace App\Exports;

use App\Models\Assistance;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AssistanceExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];
        $assistances = Assistance::all();

        foreach ($assistances as $assistance) {
            $sheets[] = new DetailAssistanceExport($assistance->id, $assistance->name);
        }

        return $sheets;
    }
}
