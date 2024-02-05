<?php

namespace App\Models\planner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadtimeWithfinishings extends Model
{
    protected $fillable = [
        'kva',
        'jeda_QCTransfer',
        'jeda_QC',
        'jeda_finishing',
        'jeda_confa',
        'jeda_supmatconfa',
        'jeda_susuncore',
        'jeda_mould',
        'jeda_supfixcore',
        'jeda_core',
        'jeda_hv',
        'jeda_lv',
        'jeda_supmatmould',
        'jeda_supmatinscoil',
        'jeda_inspaper',
    ];
    use HasFactory;
}