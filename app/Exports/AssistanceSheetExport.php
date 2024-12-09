<?php

namespace App\Exports;

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
        $data = Recipient::whereHas('assistance', function ($query) {
            $query->where('id', $this->assistanceId);
        })
            ->where('year', $this->year)
            ->get();

        return $data;
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
                $event->sheet->setCellValue('A2', 'DESA TAHUN ' . $this->year);

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

                // Menambahkan teks tanda tangan di bawah data
                $signatureRow = $highestRow + 3; // Posisi baris tanda tangan
                $event->sheet->setCellValue('B' . $signatureRow, 'Mengetahui');
                $event->sheet->setCellValue('D' . $signatureRow, 'Pantungo, ' . now()->format('j F Y'));

                $event->sheet->setCellValue('B' . ($signatureRow + 1), 'Kepala Desa Pantungo');
                $event->sheet->setCellValue('D' . ($signatureRow + 1), 'Pelaksana Kegiatan');

                // Baris untuk nama dan jabatan setelah tanda tangan
                $event->sheet->setCellValue('B' . ($signatureRow + 5), 'SOFYAN GANI, SE');
                $event->sheet->setCellValue('D' . ($signatureRow + 5), 'IDRIS K. MOHAMAD, S.KOM');

                // Mengatur posisi dan style tanda tangan
                $event->sheet->getStyle('B' . $signatureRow . ':D' . ($signatureRow + 5))->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Bold nama
                $event->sheet->getStyle('B' . ($signatureRow + 5) . ':D' . ($signatureRow + 5))->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                ]);
            },
        ];
    }
}
