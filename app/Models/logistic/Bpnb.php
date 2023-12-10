<?php

namespace App\Models\logistic;

use App\Models\purchaser\po;
use App\Models\logistic\BpnbNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bpnb extends Model
{
    use HasFactory;
    protected $fillable = ['no_bon', 'id_po', 'tgl_bpnb', 'surat_jalan', 'tgl_suratjalan'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($bpnb) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $noBon = BpnbNumber::first()->no_bon;
            $nextNumber = 'B' . str_pad((int) substr($noBon, 1) + 1, 3, '0', STR_PAD_LEFT);

            // Set nilai no_bon
            $bpnb->no_bon = $nextNumber;

            // Update nomor urut terakhir
            BpnbNumber::first()->update(['no_bon' => $nextNumber]);
        });
    }

    /**
     * Get the po that owns the Bpnb
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function po(): BelongsTo
    {
        return $this->belongsTo(po::class, 'id_po', 'id_po');
    }
}
