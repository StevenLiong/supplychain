<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkcenterOilTrafo extends Model
{
    protected $fillable = [
        'nama_workcenter',
    ];
    use HasFactory;

    public function mps()
    {
        return $this->hasMany(Mps::class, 'nama_workcenter', 'nama_workcenter');
    }
}