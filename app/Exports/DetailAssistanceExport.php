<?php

namespace App\Exports;

use App\Models\Assistance;
use App\Models\DetailAssistance;
use App\Models\Profile;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class DetailAssistanceExport implements FromCollection, WithTitle, WithCustomStartCell, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    use Exportable;

    protected $row;
    protected $assistanceId;
    protected $assistanceName;

    public function __construct($assistanceId, $assistanceName)
    {
        $this->assistanceId = $assistanceId;
        $this->assistanceName = $assistanceName;
        $this->row = 1;
    }

    public function title(): string
    {
        return $this->assistanceName;
    }

    public function collection()
    {
        return DetailAssistance::where('assistance_id', $this->assistanceId)->latest()->get();
    }

    /**
     * Map data dari DetailAssistance untuk setiap baris.
     * 
     * @param DetailAssistance $detailAssistance
     * @return array
     */
    public function map($detailAssistance): array
    {
        return [
            $this->row++,
            $detailAssistance->input_date,
            $detailAssistance->additional_data,
            $detailAssistance->additional_data,
        ];
    }

    /**
     * Define headings untuk export Excel.
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Keterangan',
            'Jumlah',
        ];
    }

    /**
     * Tentukan sel awal untuk data di Excel.
     * 
     * @return string
     */
    public function startCell(): string
    {
        return 'B10';
    }

    /**
     * Daftar event untuk memformat sheet setelah data dimuat.
     * 
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $profile = Profile::first();

                // Sisipkan gambar/logo
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(asset('storage/upload/logo/' . $profile->village_logo));
                $drawing->setHeight(90);
                $drawing->setCoordinates('D2');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Menggabungkan sel untuk kop surat
                $event->sheet->mergeCells('B7:E7');
                $event->sheet->mergeCells('B8:E8');
                $event->sheet->mergeCells('B9:E9');

                // Menambahkan teks kop surat
                $event->sheet->setCellValue('B7', $profile->village_name);
                $event->sheet->setCellValue('B8', $profile->address);
                $event->sheet->setCellValue('B9', 'Data Bantuan');

                // Styling kop surat agar teks berada di tengah
                $event->sheet->getStyle('B7:E9')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Menerapkan border dan perataan pada data
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
                $range = 'B10:' . $highestColumn . $highestRow;
                $event->sheet->getStyle($range)->applyFromArray($styleArray);
            },
        ];
    }
}
