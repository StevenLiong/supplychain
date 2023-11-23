<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class jenispembelian extends Model
{
    use HasFactory;
    protected $jenispembelian = 'jenisPembelian';

    protected $fillable = [
        'id_jenispembelian',
        'name_pembelian',
        'valuta',
    ];
    
    public function po(): HasOne
    {
        return $this->hasOne(mr::class,'id_po','id_po');
    }
}
