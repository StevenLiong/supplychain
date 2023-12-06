<?php

namespace App\Models\purchaser;

use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class mr extends Model
{
    use HasFactory;

    protected $guarded = [
 
    ];

    protected $fillable = [
        'id_mr',
        'keterangan',
        'status_mr',
        'tanggal_mr',
        'accepted_date',
        'id_division',
        'id_po',
    ];

    public $timestamps = false;

    //belongsto kalau di punya FK, hasMany dan hasone tidak punya FK ditabel sebelumnya.
    public function po(): HasOne
    {
        return $this->HasOne(po::class,'id_po','id_po');
    }
    public function division(): BelongsTo
    {
        return $this->belongsTo(division::class,'id_division','id_division');
    }
    public function pesanan(): HasMany 
    {
        return $this->HasMany(pesanan::class,'id_mr','id_mr');
    }

}
