<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MrExport implements FromCollection, WithHeadings
{
    protected $dataExel;

    public function __construct($dataExel)
    {
        $this->dataExel = $dataExel;
    }

    public function collection()
    {
        return $this->dataExel;
    }

    public function headings(): array
    {
        return [
            'ID Mr', 
            'Kode Material', 
            'Quantity',
        ];
    }
}
