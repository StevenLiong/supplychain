<?php

namespace App\Models\purchaser;

use App\Models\logistic\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class po extends Model
{
    use HasFactory;
    protected $table = 'po';
    public $timestamps  = false;
    protected $guarded = [];

    protected $fillable = [
        'id_po',
        'tanggal_po',
        'status_po',
        'jenispembelian',
        'tanggal_kirim',
        'keterangan',
        'jenispembayaran',
        'term',
        'kd_supplier',
        'id_delivery',
        'id_mr',
    ];

    public function mr(): BelongsTo
    {
        return $this->belongsTo(mr::class, 'id_mr', 'id_mr');
    }
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(delivery::class, 'id_delivery', 'id_delivery');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'kd_supplier', 'kd_supplier');
    }
}
