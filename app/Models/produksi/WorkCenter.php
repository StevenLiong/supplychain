<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        //
    ];

    public function man_hour(): HasMany
    {
        return $this->hasMany(ManHour::class,'manhour_id','id');
    }
}
