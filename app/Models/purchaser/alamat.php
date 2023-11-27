<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class alamat extends Model
{
    use HasFactory;
    protected $alamat = 'alamat';

    protected $fillable = [
        'id_alamat',
        'alamat',
    ];
    public function po(): HasOne
    {
        return $this->hasOne(po::class,'id_po','id_po');
    }
}
