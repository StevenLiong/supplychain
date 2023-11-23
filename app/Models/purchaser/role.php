<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class role extends Model
{
    use HasFactory;
    protected $role = 'role';

    protected $fillable = [
        'id_role',
        'name_role',
    ];

    public function User(): HasMany
    {
        return $this->hasMany(User::class, 'id_user', 'id_user');
    }
}
