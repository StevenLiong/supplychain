<?php

namespace App\Models\purchaser;

use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class division extends Model
{
    use HasFactory;
    protected $table = 'division';
    public $timestamps = false;

    protected $fillable = [
        'id_division',
        'name_division',
    ];

    public function mr(): HasOne
    {
        return $this->hasOne(mr::class,'id_mr','id_mr');
    }
}
