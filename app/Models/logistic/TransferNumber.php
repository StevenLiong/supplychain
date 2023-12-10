<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferNumber extends Model
{
    use HasFactory;
    protected $fillable = ['no_bon'];
}
