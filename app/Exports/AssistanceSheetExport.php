<?php

namespace App\Exports;

use App\Models\Person;
use App\Models\Recipient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AssistanceSheetExport implements FromCollection, WithTitle, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    protected $assistanceId;
    protected $assistanceName;
    protected $row;
    protected $year;

    public function __construct($assistanceId, $assistanceName, $year)
    {
        $this->assistanceId = $assistanceId;
        $this->assistanceName = $assistanceName;
        $this->row = 1;
        $this->year = $year;
    }

    public function collection()
    {
        return Recipient::where('assistance_id', $this->assistanceId)
            ->where('year', $this->year)
            ->get();
    }

    public function title(): string
    {
        return $this->assistanceName;
    }

    /**
     * @var Recipient $recipient
     */
    public function map($recipient): array
    {
        return [
            $this->row++,
            $recipient->person->name,
            $recipient->person->village->name,
            '',
        ];
    }

    public function headings(): array
    {
        $headings = [
            'NO',
            'NAMA',
            'ALAMAT',
            'KETERANGAN',
        ];

        return $headings;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                // Menggabungkan sel untuk heading (kop surat)
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');

                // Menambahkan teks kop surat
                $event->sheet->setCellValue('A1', 'DAFTAR PENERIMA');
                $event->sheet->setCellValue('A2', 'DESA TAHUN');

                // Styling kop surat agar teks berada di tengah
                $event->sheet->getStyle('A1:D2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Rata tengah horizontal
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Rata tengah vertikal
                    ],
                ]);


                $highestColumn = $event->sheet->getHighestColumn();
                $highestRow = $event->sheet->getHighestRow();

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];

                $range = 'A4:' . $highestColumn . $highestRow;
                $event->sheet->getStyle($range)->applyFromArray($styleArray);
            },
        ];
    }
}
