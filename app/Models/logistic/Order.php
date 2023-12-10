<?php

namespace App\Models\logistic;

use App\Models\planner\Detailbom;
use App\Models\logistic\OrderNumber;
use App\Models\planner\Wo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['no_bon', 'nama_workcenter', 'id_wo', 'tanggal_bon'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $noBon = OrderNumber::first()->no_bon;
            $nextNumber = 'F' . str_pad((int) substr($noBon, 1) + 1, 3, '0', STR_PAD_LEFT);

            // Set nilai no_bon
            $order->no_bon = $nextNumber;

            // Update nomor urut terakhir
            OrderNumber::first()->update(['no_bon' => $nextNumber]);
        });
    }

    public function getStatusTextAttribute()
    {
        switch ($this->attributes['status']) {
            case 0:
                return 'Request';
            case 1:
                return 'Completed';
            default:
                return 'Unknown Status';
        }
    }
    /**
     * Get the detailbom that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function detailbom(): BelongsTo
    {
        return $this->belongsTo(Detailbom::class, 'id_boms', 'id_boms');
    }

    /**
     * Get the bom that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bom(): BelongsTo
    {
        return $this->belongsTo(BOM::class, 'id_bom', 'id');
    }

    

    /**
     * Get the wo that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wo(): BelongsTo
    {
        return $this->belongsTo(Wo::class, 'id_wo', 'id_wo');
    }

    /**
     * Get the cutting that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cutting(): BelongsTo
    {
        return $this->belongsTo(Cutting::class);
    }
}
