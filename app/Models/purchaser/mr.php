<?php

namespace App\Models;

use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class mr extends Model
{
    use HasFactory;

    protected $guarded = [
 
    ];

    protected $fillable = [
        'id_mr',
        'qty_mr',
        'keterangan',
        'status_mr',
        'id_pesanan',
        'tanggal_mr',
        'id_division',
        'id_ppic',
    ];

    public $timestamps = false;

    //belongsto kalau di punya FK, hasMany dan hasone tidak punya FK ditabel sebelumnya.
    public function po(): HasMany
    {
        return $this->hasMany(po::class,'id_po','id_po');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(status::class,'id_status','id_status');
    }
    public function division(): BelongsTo
    {
        return $this->belongsTo(division::class,'id_division','id_division');
    }
    public function pesanan(): HasMany 
    {
        return $this->HasMany(pesanan::class,'id_mr','id_mr');
    }
    public function ppic(): BelongsTo
    {
        return $this->belongsTo(ppic::class,'id_ppic','id_ppic');
    }

}
