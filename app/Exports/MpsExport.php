<?php

namespace App\Exports;

use App\Models\Mps;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MpsExport implements FromCollection, WithHeadings
{
    protected $dataMps;
    protected $id_wo;

    public function __construct($dataMps, $id_wo)
    {
        $this->dataMps = $dataMps;
        $this->id_wo = $id_wo;
        // dd($id_wo);
    }

    public function collection()
    {
        $counter = 1;

        return collect($this->dataMps, $this->id_wo)->map(function ($row) use (&$counter) {
            // dd($dataWo);
            return [
                'Nomor' => $counter++,
                'id_wo' => $this->id_wo,
                'project' => $row['project'],
                'production_line' => $row['production_line'],
                'kva' => $row['kva'],
                'jenis' => $row['jenis'],
                'qty_trafo' => $row['qty_trafo'],
                'deadline' => $row['deadline'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Work Order',
            'Project Name',
            'Production Line',
            'KVA',
            'Jenis Trafo',
            'Quantity',
            'Deadline',
        ];
    }
}