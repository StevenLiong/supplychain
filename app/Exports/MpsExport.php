<?php

namespace App\Exports;

use App\Models\Mps;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MpsExport implements FromCollection, WithHeadings
{
    protected $dataMps;

    public function __construct($dataMps)
    {
        $this->dataMps = $dataMps;
    }

    public function collection()
    {
        return $this->dataMps;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Work Order',
            'Project Name',
            'Production Line',
            'KVA',
            'Jenis Trafo',
            'Quantity',
            'Lead Time',
            'Deadline',
        ];
    }
}