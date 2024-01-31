<?php

namespace App\Models\planner;

use App\Models\logistic\Finishedgood;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanbanfg extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_fg',
        'nama_item',
        'max_kanban',
        'stock_on_hand',
        'supplier',
        'unit',
        'status',
        'realisasi',
        'email_status',
        'peruntukan_unit',
        'stock_akhir',
    ];

    public function finishedGood()
    {
        return $this->belongsTo(Finishedgood::class, 'kode_fg', 'kd_finishedgood');
    }

    // public function updateStockOnHand()
    // {
    //     $kode_fg = $this->kode_fg;

    //     $finishedGood = Finishedgood::where('kd_finishedgood', $kode_fg)->first();

    //     if ($finishedGood) {
    //         $qty = $finishedGood->qty;
    //         $this->stock_on_hand = $qty;
    //     } else {
    //         $this->stock_on_hand = 0;
    //     }

    //     $this->stock_akhir = $this->stock_on_hand - $this->peruntukan_unit;

    //     if ($this->stock_akhir <= $this->max_kanban) {
    //         $this->unit = $this->max_kanban - $this->stock_akhir;
    //     } else {
    //         $this->unit = 0;
    //     }

    //     if($this->unit > 0){
    //         $this->status = 'Order';
    //         $this->email_status = 0;
    //     }else{
    //         $this->status = 'Aman';
    //     }

    //     $this->save();
    // }

    public function updateStockOnHand()
    {
        $kode_fg = $this->kode_fg;

        $finishedGood = Finishedgood::where('kd_finishedgood', $kode_fg)->first();

        if ($finishedGood) {
            $qty = $finishedGood->qty;
            $this->stock_on_hand = $qty;
        } else {
            $this->stock_on_hand = 0;
        }

        $this->stock_akhir = $this->stock_on_hand - $this->peruntukan_unit;

        if ($this->stock_akhir <= $this->max_kanban) {
            $this->unit = $this->max_kanban - $this->stock_akhir;
        } else {
            $this->unit = 0;
        }

        // Check if there's a change in the unit value
        $unitChanged = $this->isDirty('unit');

        if ($this->unit > 0) {
            $this->status = 'Order';

            // Update email_status only if there's a change in the unit value
            if ($unitChanged) {
                $this->email_status = 0;
            }
        } else {
            $this->status = 'Aman';
        }

        $this->save();
    }


    public function updateStatus()
    {
        $kode_fg = $this->kode_fg;

        $finishedGood = Finishedgood::where('kd_finishedgood', $kode_fg)->first();
        // dd($finishedGood);

        if($this->unit > 0)
        {
            $this->fg_status = 1;
        }else{
            $this->fg_status = 0;
        }
        $this->save();
    }

}
