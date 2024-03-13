<?php

namespace App\Imports;

use App\Models\logistic\Finishedgood;
use App\Models\planner\Wo;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class WoImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    use Importable;

    public $startRow = 4;

    public function model(array $row)
    {
        if ($this->startRow === 1) {
            $this->startRow = 0;
            return null;
        }

        if (empty($row)) {
            return null;
        }
        
        // print_r($row);
        // dd($row);

        return new Wo([
            'id_wo' => $row['1'],
            'start_date' => $row['2'],
            'finish_date' => $row['3'],
            'id_boms' => $row['13'],
            'id_fg' => $row['14'],
            'qty_trafo' => $row['15'],
        ]);
    }
}
