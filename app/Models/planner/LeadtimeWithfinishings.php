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
        'jeda_QC_deadline',
        'jeda_finishing',
        'jeda_finishing_deadline',
        'jeda_confa',
        'jeda_confa_deadline',
        'jeda_supmatconfa',
        'jeda_susuncore',
        'jeda_susuncore_deadline',
        'jeda_mould',
        'jeda_mould_deadline',
        'jeda_supfixcore',
        'jeda_core',
        'jeda_hv',
        'jeda_hv_deadline',
        'jeda_lv',
        'jeda_lv_deadline',
        'jeda_supmatmould',
        'jeda_supmatinscoil',
        'jeda_inspaper',
        'jeda_inspaper_deadline',
    ];
    use HasFactory;
}