<?php

namespace App\Imports;

use App\Models\logistic\Finishedgood;
use App\Models\planner\Fgoods;
use App\Models\planner\Kanbanfg;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class FinishgoodImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    use Importable;

    public $startRow = 2;

    public function model(array $row)
    {
        if ($this->startRow === 1) {
            $this->startRow = 0;
            return null;
        }

        if (empty($row)) {
            return null;
        }

        $kd_finishedgood = $row['kode_fg'];

        $fgoods = Finishedgood::where('kd_finishedgood', $kd_finishedgood)->first();

        $stockOnHand = $fgoods ? $fgoods->qty : 0;
        // $stockOnHand = '1';

        $unit = max(0, $row['max_kanban'] - $stockOnHand);

        $status = ($unit > 0) ? 'Order' : 'Aman';

        return new Kanbanfg([
            'no' => $row['no'],
            'kode_fg' => $row['kode_fg'],
            'nama_item' => $row['nama_item'],
            'max_kanban' => $row['max_kanban'],
            'stock_on_hand' => $stockOnHand,
            'unit' => $unit,
            'status' => $status,
        ]);
    }
}
