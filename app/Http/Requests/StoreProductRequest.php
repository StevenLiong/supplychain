<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_product' => [],
            // 'id_fg' => [],
            'kategori' => [],
            // 'nomor_so' => [],
            'kd_manhour' => [],
            'nomor_so' => ['required'],
            'id_fg' => ['required'],
            'ukuran_kapasitas' => ['required'],
            'total_hour' => ['required'],
            // 'ukuran_kapasitas' => [],
            'coil_lv' => [],
            'coil_hv' => [],
            'potong_leadwire' => [],
            'potong_isolasi' => [],
            'hv_moulding' => [],
            'hv_casting' => [],
            'hv_demoulding' => [],
            'lv_bobbin' => [],
            'lv_moulding' => [],
            'touch_up' => [],
            'type_susun_core' => [],
            'wiring' => [],
            'instal_housing' => [],
            'bongkar_housing' => [],
            'pembuatan_cu_link' => [],
            'others' => [],
            'accesories' => [],
            'potong_isolasi_fiber' => [],
            // 'qc_testing' => [],
            'totalHour_coil_making' => [],
            'totalHour_MouldCasting' => [],
            'totalHour_CoreCoilAssembly' => [],
            'totalHour_QCTest' => [],
            'hour_coil_lv' => [],
            'hour_coil_hv' => [],
            'hour_potong_leadwire' => [],
            'hour_potong_isolasi' => [],
            'hour_hv_moulding' => [],
            'hour_hv_casting' => [],
            'hour_hv_demoulding' => [],
            'hour_lv_bobbin' => [],
            'hour_lv_moulding' => [],
            'hour_touch_up' => [],
            'hour_type_susun_core' => [],
            'hour_wiring' => [],
            'hour_instal_housing' => [],
            'hour_bongkar_housing' => [],
            'hour_pembuatan_cu_link' => [],
            'hour_others' => [],
            'hour_accesories' => [],
            'hour_potong_isolasi_fiber' => [],
            'hour_qc_testing' => [],
            // 'total_hour' => [],
        ];
    }
}
