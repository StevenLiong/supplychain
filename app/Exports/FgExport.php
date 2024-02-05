<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;


class FgExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $dataFg;

    public function __construct($dataFg)
    {
        $this->dataFg = $dataFg;
    }

    public function collection()
    {
        return $this->dataFg;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Finish Good',
            'Nama Finish Good',
            'Max Kanban',
            'Stock On Hand',
            'Unit (Qty yang harus dipesan)',
            'Status',
            'peruntukan_unit',
            'stock_akhir',
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