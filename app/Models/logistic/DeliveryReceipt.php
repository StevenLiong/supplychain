<?php

namespace App\Models\logistic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceipt extends Model
{
    protected $table = 'delivery_receipt';
    protected $fillable = [
        'Tanggal_Delivery', 'NO_SO', 'NO_DO', 'NO_WO'
    ];
}
