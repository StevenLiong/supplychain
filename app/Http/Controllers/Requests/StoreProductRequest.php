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
            'nama_product' => [ 'string', 'max:255'],
            'kategori' => [ 'string', 'max:255'],
            'nomor_so' => ['required', 'string', 'max:255'],
            'ukuran_kapasitas' => ['required'],
            'coil_lv' => ['required','string', 'max:100'],
            'coil_hv' => ['required','string', 'max:100'],
            'potong_leadwire' => ['required','string', 'max:100'],
            'potong_isolasi' => [],
            'hv_moulding' => ['required','string', 'max:100'],
            'hv_casting' => ['required','string', 'max:100'],
            'hv_demoulding' => ['required','string', 'max:100'],
            'lv_bobbin' => [],
            'lv_moulding' => [],
            'touch_up' => [],
            'type_susun_core' => ['required','string', 'max:100'],
            'wiring' => ['required','string', 'max:100'],
            'instal_housing' => ['required','string', 'max:100'],
            'bongkar_housing' => ['required','string', 'max:100'],
            'pembuatan_cu_link' => ['string', 'max:100'],
            'others' => [],
            'accesories' => [],
            'potong_isolasi_fiber' => [],
            // 'routine_test' => [],
            'total_hour' => ['required','string', 'max:100'],
        ];
    }

}
