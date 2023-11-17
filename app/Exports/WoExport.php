<?php

namespace App\Exports;

use App\Models\Wo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WoExport implements FromCollection, WithHeadings
{
    protected $dataWo;

    public function __construct($dataWo)
    {
        $this->dataWo = $dataWo;
    }

    public function collection()
    {
        return $this->dataWo;
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'Kode BOM',
            'Kode WO',
            'Kode Man Hour',
            'Quantity Trafo',
            'Kode SO',
            'Start Date',
            'Finish Date',
        ];
    }
}