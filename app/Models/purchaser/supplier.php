<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class supplier extends Model
{
    use HasFactory;
    protected $suplier = 'suplier';

    protected $fillable = [
        'id_suplier',
        'name_suplier',
        'alamat',
    ];

    public function po(): HasOne
    {
        return $this->hasOne(po::class,'id_po','id_po');
    }
}
