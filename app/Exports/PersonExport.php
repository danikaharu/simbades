<?php

namespace App\Exports;

use App\Models\Person;
use App\Models\Profile;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PersonExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    use Exportable;

    protected $lowIncome;
    protected $dynamicTitle;

    public function __construct($lowIncome = false, $dynamicTitle = 'Data Kependudukan')
    {
        $this->lowIncome = $lowIncome;
        $this->dynamicTitle = $dynamicTitle;
    }

    public function collection()
    {
        if ($this->lowIncome) {
            return Person::where('income_month', '<=', '500000')->get();
        }
        return Person::latest()->get();
    }

    /**
     * @var Person $person
     */
    public function map($person): array
    {
        return [
            $person->family_card,
            $person->identification_number,
            $person->name,
            $person->gender(),
            $person->kinship,
            $person->birth_place,
            $person->birth_date,
            $person->religion,
            $person->last_education,
            $person->work->name,
            $person->income_month,
            $person->village->name,
        ];
    }

    public function headings(): array
    {
        $headings = [
            'NO KK',
            'NIK',
            'Nama',
            'Jenis Kelamin',
            'Hubungan Keluarga',
            'Tempat Lahir',
            'Tgl Lahir',
            'Agama',
            'Pendidikan Terakhir',
            'Pekerjaan Utama',
            'Penghasilan Perbulan',
            'Dusun',
        ];

        return $headings;
    }

    public function startCell(): string
    {
        return 'A10';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $profile = Profile::first();

                // Menyisipkan gambar/logo
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('storage/upload/logo/' . $profile->village_logo)); // Sesuaikan path logo
                $drawing->setHeight(90); // Tinggi logo
                $drawing->setCoordinates('G2'); // Lokasi penempatan logo
                $drawing->setOffsetX(-20);
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Menggabungkan sel untuk heading (kop surat)
                $event->sheet->mergeCells('A7:L7');
                $event->sheet->mergeCells('A8:L8');
                $event->sheet->mergeCells('A9:L9');

                // Menambahkan teks kop surat
                $event->sheet->setCellValue('A7', $profile->village_name);
                $event->sheet->setCellValue('A8', $profile->address);
                $event->sheet->setCellValue('A9', $this->dynamicTitle);

                // Styling kop surat agar teks berada di tengah
                $event->sheet->getStyle('A7:L9')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
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

                $range = 'A10:' . $highestColumn . $highestRow;
                $event->sheet->getStyle($range)->applyFromArray($styleArray);
            },
        ];
    }
}
