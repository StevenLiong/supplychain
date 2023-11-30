<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class delivery extends Model
{
    use HasFactory;
    protected $table= 'delivery';
    public $timestamps = false;

    protected $fillable = [
        'id_delivery',
        'alamat',
    ];
    
    public function po(): HasOne
    {
        return $this->hasOne(mr::class,'id_po','id_po');
    }
}
