<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FgExport implements FromCollection, WithHeadings
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
}