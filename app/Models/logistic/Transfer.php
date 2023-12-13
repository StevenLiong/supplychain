<?php

namespace App\Models\logistic;

use App\Models\planner\Wo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = ['no_bon', 'id_wo', 'status'];
    protected $dates = ['updated_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($transfer) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $noBon = TransferNumber::first()->no_bon;
            $nextNumber = 'T' . str_pad((int) substr($noBon, 1) + 1, 3, '0', STR_PAD_LEFT);

            // Set nilai no_bon
            $transfer->no_bon = $nextNumber;

            // Update nomor urut terakhir
            TransferNumber::first()->update(['no_bon' => $nextNumber]);
        });
    }
    /**
     * Get the wo that owns the Transfer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wo(): BelongsTo
    {
        return $this->belongsTo(Wo::class, 'id_wo', 'id_wo');
    }
}
