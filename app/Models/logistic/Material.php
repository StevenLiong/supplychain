<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'kd_material',
        'nama_material',
        'spesifikasi_material',
        'satuan',
        'jumlah',
        'qrcode',
        'barcode'
    ];
}
