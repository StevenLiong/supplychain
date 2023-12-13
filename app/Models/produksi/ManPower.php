<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class ManPower extends Model
{
    use HasFactory;

    protected $table = 'man_power';

    protected $fillable = [
        'nama',
        'nik',
        'status_mp',
        'tanggal_lahir',
        // 'usia',
    ];

    // Event listener untuk event creating

    

    public static function boot()
    {
        parent::boot();

        static::creating(function ($man_power) {
            $man_power->usia = Carbon::parse($man_power->tanggal_lahir)->age;
        });
    }
}
