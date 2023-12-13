<?php

namespace App\Models\logistic;

use App\Models\logistic\CuttingNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cutting extends Model
{
    use HasFactory;
    protected $fillable = ['no_bon', 'bon_f','tanggal_bon', 'status'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $noBon = CuttingNumber::first()->no_bon;
            $nextNumber = 'E' . str_pad((int) substr($noBon, 1) + 1, 3, '0', STR_PAD_LEFT);

            // Set nilai no_bon
            $order->no_bon = $nextNumber;

            // Update nomor urut terakhir
            CuttingNumber::first()->update(['no_bon' => $nextNumber]);
        });
    }

    public function getStatusTextAttribute()
    {
        switch ($this->attributes['status']) {
            case 0:
                return 'Sending';
            case 1:
                return 'Completed';
            default:
                return 'Unknown Status';
        }
    }

    /**
     * Get the order that owns the Cutting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'bon_f', 'id');
    }

    

    /**
     * Get all of the details for the Cutting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(detail_cutting::class);
    }
}
