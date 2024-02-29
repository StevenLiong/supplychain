<?php

namespace App\Exports;

use App\Models\Kanba;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\setAlignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;


class DetailBomExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $dataBom;

    public function __construct($dataBom)
    {
        $this->dataBom = $dataBom;
    }

    public function collection()
    {
        // return $this->dataBom;
        $counter = 1;

        return collect($this->dataBom)->map(function ($row) use (&$counter) {
            return [
                'Nomor' => $counter++,
                'nama_workcenter' => $row['nama_workcenter'],
                'id_materialbom' => $row['id_materialbom'],
                'nama_material' => $row['nama_materialbom'],
                'uom' => $row['uom_material'],
                'usage_material' => $row['usage_material'],
                'keterangan' => $row['keterangan'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Nama Work Center',
            'Kode Material',
            'Nama Material',
            'UOM',
            'Usage Material',
            'Keterangan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle(
                    $event->sheet->calculateWorksheetDimension()
                )->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $event->sheet->getDelegate()->getStyle('A1:W1')->getFont('')->setSize(12);
            },
        ];
    }
}