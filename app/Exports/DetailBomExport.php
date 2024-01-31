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
        return $this->dataBom;
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function(AfterSheet $event) {
    //             $lastColumn = $event->sheet->getHighestColumn();
    //             $lastRow = $event->sheet->getHighestRow();
        
    //             $range = 'A1:' . $lastColumn . $lastRow;
        
    //             $event->sheet->getStyle($range)->applyFromArray([
    //                 'borders' => [
    //                     'allBorders' => [
    //                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                         'color' => ['argb' => '#000000'],
    //                     ],
    //                 ],
    //             ]);
    //         }
    //     ];
    // }

    public function headings(): array
    {
        return [
            'No',
            'Kode Bill of Material',
            'Nama Work Center',
            'Kode Material',
            'Nama Material',
            'UOM',
            'Quantity',
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