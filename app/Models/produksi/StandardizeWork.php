<?php

namespace App\Models\produksi;

use App\Models\planner\Wo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StandardizeWork extends Model
{
    use HasFactory;
    protected $table = 'standardize_works';

    protected $fillable = [
        'id_dry_cast_resin',
        'id_dry_non_resin',
        'id_ct',
        'id_vt',
        'id_oil_standard',
        'id_oil_custom',
        'id_repair',
        'total_hour',
        'id_fg',
        'kd_manhour',
        'nama_product',
        'nomor_so',
        'ukuran_kapasitas',
    ];



    public function dry_cast_resin(): BelongsTo
    {
        return $this->belongsTo(DryCastResin::class, 'id_dry_cast_resin', 'id');
    }
    public function dry_non_resin(): BelongsTo
    {
        return $this->belongsTo(DryNonResin::class, 'id_dry_non_resin', 'id');
    }
    public function vt(): BelongsTo
    {
        return $this->belongsTo(Vt::class, 'id_vt', 'id');
    }
    public function ct(): BelongsTo
    {
        return $this->belongsTo(Ct::class, 'id_ct', 'id');
    }
    public function oil_custom(): BelongsTo
    {
        return $this->belongsTo(OilCustom::class, 'id_oil_custom', 'id');
    }
    public function oil_standard(): BelongsTo
    {
        return $this->belongsTo(OilStandard::class, 'id_oil_standard', 'id');
    }
    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class, 'id_repair', 'id');
    }
}
