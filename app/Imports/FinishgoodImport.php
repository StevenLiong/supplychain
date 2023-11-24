<?php

namespace App\Imports;

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
            $this->startRow = 0; // Set the first row as the current row
            return null; // Return null to ignore the second row
        }

        if (empty($row)) {
            return null; // Ignore empty rows
        }

        $fgoods = Fgoods::where('kd_finishedgood', $row['kode_fg'])->first();

        if (!$fgoods) {
            return null;
        }

        $stockOnHand = $fgoods->qty;

        // Calculate 'unit' and ensure it's not below 0
        $unit = max(0, $row['max_kanban'] - $stockOnHand);

        // Calculate 'status' based on the 'unit' value
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
