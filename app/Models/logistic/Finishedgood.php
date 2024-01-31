<?php

namespace App\Models\logistic;

use App\Models\planner\Kanbanfg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishedgood extends Model
{
    use HasFactory;
    protected $fillable = ['no_transfer','id_wo', 'kd_finishedgood', 'qty', 'kva', 'nsp', 'nsk', 'gudang'];

    public function kanbanfg()
    {
        return $this->belongsTo(Kanbanfg::class, 'kd_finishedgood', 'kode_fg');
    }
}
