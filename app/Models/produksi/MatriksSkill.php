<?php

namespace App\Models\produksi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriksSkill extends Model
{
    use HasFactory;

    protected $table = 'matriks_skill';

    protected $fillable = [
        'nama_mp',
        'production_line',
        'kategori_produk',
        'proses',
        'tipe_proses',
        'skill',
    ];
}
