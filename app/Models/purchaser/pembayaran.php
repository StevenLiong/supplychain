<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class pembayaran extends Model
{
    use HasFactory;
    protected $pembayaran = 'pembayaran';

    protected $fillable = [
        'id_pembayaran',
        'jenis_pembayaran',
    ];
    public function po(): HasOne
    {
        return $this->hasOne(po::class,'id_po','id_po');
    }

}
