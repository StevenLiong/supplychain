<?php

namespace App\Imports;

use App\Models\planner\Bom;
use App\Models\planner\Stock;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class MaterialImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    use Importable;

    public $startRow = 1;
    public function model(array $row)
    {
        if ($this->startRow === 2) {
            $this->startRow = 1;
            return null;
        }

        if (empty($row)) {
          return null;
      }

        print_r($row);
        dd($row);

        // $calculatedValue = $row['usage_of_material'];

        return new Stock([
            'no' => $row['no'],
            'item_code' => $row['item_code'],
            'item_name' => $row['item_name'],
            'tiga_item_name' => $row['3rd_item_name'],
            'supplier' => $row['supplier'],
            'rop' => ceil(floatval($row['rop'])),
            'max' => ceil(floatval($row['max'])),
            'rop_safety' => ceil(floatval($row['rop_safety'])),
            'max_safety' => ceil(floatval($row['max_safety'])),
            'safety_stock' => ceil(floatval($row['safety_stock'])),
        ]);
    }
}
