<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nomor_so' => [],
            'ukuran_kapasitas' => [],
            'coil_lv' => ['string', 'max:100'],
            'coil_hv' => ['string', 'max:100'],
            'potong_leadwire' => ['string', 'max:100'],
            'potong_isolasi' => [],
            'hv_moulding' => ['string', 'max:100'],
            'hv_casting' => ['string', 'max:100'],
            'hv_demoulding' => ['string', 'max:100'],
            'lv_bobbin' => [],
            'lv_moulding' => [],
            'touch_up' => [],
            'type_susun_core' => ['string', 'max:100'],
            'wiring' => ['string', 'max:100'],
            'instal_housing' => ['string', 'max:100'],
            'bongkar_housing' => ['string', 'max:100'],
            'pembuatan_cu_link' => ['string', 'max:100'],
            'others' => [],
            'accessories' => [],
            'potong_isolasi_fiber' => [],
            'qc_testing' => [],
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
            'total_hour' => [],
        ];
    }
}
