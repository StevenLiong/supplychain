<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class po extends Model
{
    use HasFactory;
    protected $po = 'po';

    protected $fillable = [
        'id_po',
        'tanggal_po',
        'status',
        'id_jenispembelian',
        'id_supplier',
        'id_pembayaran',
        'id_mr',
        'id_alamat',
        'id_purchaser',
    ];

    public function mr(): BelongsTo
    {
        return $this->belongsTo(mr::class,'id_mr','id_mr');
    }
    public function jenispembelian(): BelongsTo
    {
        return $this->belongsTo(jenispembelian::class,'id_jenispembelian','id_pembelian');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(supplier::class,'id_supplier','id_supplier');
    }
    public function pembayaran(): BelongsTo 
    {
        return $this->belongsTo(pembayaran::class,'id_pembayaran','id_pembayaran');
    }
    public function alamat(): BelongsTo
    {
        return $this->belongsTo(alamat::class,'id_alamat','id_alamat');
    }
    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(purchaser::class,'id_purchaser','id_purchaser');
    }

}
