<?php

namespace App\Models\produksi;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultRekomendasi extends Model
{
    use HasFactory;
    protected $table = 'resultrekomendasi';

    protected $fillable = ['end', 'hours', 'wo_id','nama_mp','nama_workcenter', 'nama_proses'];
}
