<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proses extends Model
{
    use HasFactory;

    public function man_hour(): HasMany
    {
        return $this->hasMany(ManHour::class,'manhour_id','id');
    }
}
