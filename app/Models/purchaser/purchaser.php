<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class purchaser extends Model
{
    use HasFactory;
    protected $purchaser = 'purchaser';

    protected $fillable = [
        'id_purchaser',
        'name_purchaser',
        'email',
        'nohp',
        'nip',
        'id_user',
    ];

    public function po(): HasOne
    {
        return $this->hasOne(mr::class,'id_po','id_po');
    }
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class,'id_user','id_user');
    }
}
