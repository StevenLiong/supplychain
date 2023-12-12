<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finishedgood extends Model
{
    use HasFactory;
    protected $fillable = ['no_transfer','id_wo', 'kd_finishedgood', 'qty', 'kva', 'nsp', 'nsk', 'gudang'];
}
