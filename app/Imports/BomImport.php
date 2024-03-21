<?php

namespace App\Imports;

use App\Models\planner\Bom;
use App\Models\planner\Detailbom;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;


class BomImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    // private $id_bom;

    // public function __construct($id_bom)
    // {
    //     $this->id_bom = $id_bom;
    // }
    use Importable;

    protected $idBom;

    public function __construct($idBom)
    {
        $this->idBom = $idBom;
    }

    public $startRow = 2;
    public function model(array $row)
    {
        if ($this->startRow === 1) {
            $this->startRow = 0;
            return null;
        }

        $idBom = $this->idBom;

        // Tambahkan kode debugging di sini
        // print_r($row);
        // dd($row);

        $calculatedValue = $row['usage_of_material'];

        return new Detailbom([
            'id_boms' => $idBom, 
            'nama_workcenter' => $row['nama_workcenter'],
            'id_materialbom' => $row['id_material_bom'],
            'nama_materialbom' => $row['nama_material_bom'],
            'uom_material' => $row['uom'],
            'qty_trafo' => $row['quantity_trafo'],
            'qty_material' => $row['quantity_material'],
            'tolerance' => $row['tolerance'],
            // 'usage_material' => $row['qty_trafo'] * $row['qty_material'],
            'usage_material' => $calculatedValue,
        ]);
    }
}
