<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    protected $table = 'packing_list';
    protected $fillable = [
        'Tanggal_Packing', 'NO_DO', 'NO_WO', 'NSP', 'NSK', 'packaging', 'ukuran_dimensi', 'customer'
    ];
}
