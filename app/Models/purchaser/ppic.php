<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ppic extends Model
{
    use HasFactory;
    protected $ppic = 'ppic';

    protected $fillable = [
        'id_ppic',
        'name_ppic',
        'email',
        'nohp',
        'nip',
        'id_user',
    ];

    public function mr(): HasOne
    {
        return $this->hasOne(mr::class,'id_mr','id_mr');
    }
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }

}