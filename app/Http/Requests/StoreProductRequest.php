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
            'nama_product' => [ ],
            'kategori' => [ ],
            'nomor_so' => [ ],
            'ukuran_kapasitas' => [],
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
            // 'routine_test' => [],
            'total_hour' => [],
        ];
    }

}
