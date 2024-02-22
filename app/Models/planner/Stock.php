<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'item_code',
        'item_name',
        'tiga_item_name',
        'supplier',
        'rop',
        'max',
        'rop_safety',
        'max_safety',
        'safety_stock',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class, 'item_code', 'kd_material');
    }

    public function updateStockOnHand()
    {
        $id_material = $this->item_code;
        // dd($id_material);

        $stock = Material::where('kd_material', $id_material)->first();

        if ($stock) {
            $jumlah = $stock->jumlah;
            $this->stock_on_hand = $jumlah;
        } else {
            $this->stock_on_hand = 0;
        }
        $this->save();
    }

}
