<?php

namespace App\Models\logistic;

use App\Models\logistic\Finishedgood;
use App\Models\logistic\DeliveryNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryReceipt extends Model
{
    protected $table = 'delivery_receipt';
    protected $fillable = [
        'no_delivery','id_wo', 'nsp', 'nsk', 'Tanggal_Delivery', 'NO_SO', 'NO_DO', 'packaging', 'ekspedisi', 'no_kendaraan'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($delivery) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $noDelivery = DeliveryNumber::first()->no_delivery;
            $nextNumber = 'D' . str_pad((int) substr($noDelivery, 1) + 1, 3, '0', STR_PAD_LEFT);

            // Set nilai no_bon
            $delivery->no_delivery = $nextNumber;

            // Update nomor urut terakhir
            DeliveryNumber::first()->update(['no_delivery' => $nextNumber]);
        });
    }

    /**
     * Get the finishedgood that owns the DeliveryReceipt
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function finishedgood(): BelongsTo
    {
        return $this->belongsTo(Finishedgood::class, 'id_wo', 'id_wo');
    }
}
