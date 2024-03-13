<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mps2 extends Model
{
    protected $fillable = [
        'id_wo',
        'line',
        'project',
        'qty_trafo',
        'deadline',
        'kva',
    ];
    use HasFactory;

    public function getDeadlineAttribute($value)
    {
        // Ambil nilai day, month, dan year dari atribut deadline
        $dayOnly = intval(date('j', strtotime($value)));
        $monthOnly = intval(date('m', strtotime($value)));
        $yearOnly = intval(date('Y', strtotime($value)));

        // Return array yang berisi day, month, dan year
        return [
            'day' => $dayOnly,
            'month' => $monthOnly,
            'year' => $yearOnly,
            'qty_trafo' => $this->qty_trafo,
        ];
    }
}