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
            'routine_test' => [],
            'total_hour' => [],
        ];
    }
}
