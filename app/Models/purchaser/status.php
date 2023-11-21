<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class status extends Model
{
    use HasFactory;
    protected $status = 'status';

    protected $fillable = [
        'id_status',
        'name_status',
    ];

    public function mr(): HasOne
    {
        return $this->hasOne(mr::class, 'id_mr', 'id_mr');
    }
}
