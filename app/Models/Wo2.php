<?php

namespace App\Models;

use App\Models\produksi\StandardizeWork;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wo2 extends Model
{
    protected $table = 'wo2s';
    protected $fillable = [
        'id_boms',
        'id_wo',
        'id_standardize_work',
        'qty_trafo',
        'id_so',
        'start_date',
        'finish_date',
    ];

    use HasFactory;

    public function standardize_work(): BelongsTo
    {
        return $this->belongsTo(StandardizeWork::class, 'id_standardize_work', 'id');
    }
}
