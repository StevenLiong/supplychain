<?php

namespace App\Models\planner;

use App\Models\produksi\StandardizeWork;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Wo extends Model
{
    // protected $table = 'wo';
    protected $fillable = [
        'id_boms',
        'id_standardize_work',
        'qty_trafo',
        'id_so',
        'start_date',
        'finish_date',
        'id_fg',
        'id_wo',
        'kva',
        'keterangan',
    ];

    use HasFactory;

    public function bom()
    {
        return $this->belongsTo(Bom::class, 'id_boms', 'id_bom');
    }

    // public function standardizedWork()
    // {
    //     return $this->belongsTo(StandardizeWork::class, 'id_standardize_work', 'kd_manhour');
    // }

    public function standardize_work()
    {
        // return $this->belongsTo(StandardizeWork::class, 'id_standardize_work');
        return $this->belongsTo(StandardizeWork::class, 'id_standardize_work','id');

    }
    public function finishgood()
    {
        return $this->belongsTo(Bom::class, 'id_fg', 'id_fg');
    }


}