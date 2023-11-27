<?php

namespace App\Models\planner;

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
    ];

    public function finishedgood()
    {
        return $this->hasMany(Fgoods::class, 'kd_finishedgood', 'kode_fg');
    }
}
