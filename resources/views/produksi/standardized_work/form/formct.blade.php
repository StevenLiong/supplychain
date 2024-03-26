@extends('produksi.standardized_work.layout')
@section('content')
    <style>
        label {
            font-weight: bold;
        }

        .col-lg-6 {
            padding: 2;
        }

        td {
            padding-left: 5px;
            padding-right: 5px;
        }

        tr {
            padding-bottom: 0px;
        }

        .label {
            margin-bottom: 0px;
        }
    </style>
    <h5 class="text-center text-sm-center text-xs-center my-1 header-title card-title" style="font-size: 30px;color:#d02424;">
        <b>PERHITUNGAN MAN HOUR</b>
    </h5>
    <form class="login-content floating-label " method="post" action="{{ route('store.ct') }}">
        @csrf
        <div class="row px-2">
            <div class="col-lg-12">
                <div class="card card-body my-1 py-1">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="alert-title">
                                <h4>Whoops!</h4>
                            </div>
                            There are some problems with your input.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row align-items-center justify-content-center px-3 ">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-left input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-size-lg"><b>TOTAL HOUR</b></span>
                            </div>
                            <div class="input-group-append">
                                <input type="text" class="input-group-text font-size-lg bg-warning" id="total_hour"
                                    name="total_hour" value="{{ old('total_hour') }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                            <button type="reset" class="btn btn-warning m-2">
                                <i class="fa-solid fa-rotate-left mr-2"> </i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary m-2"> <i
                                    class="fa-regular fa-floppy-disk mr-2"></i>Save</button>
                            {{-- <a href="#" class="btn btn-info m-2" data-target=".preview" onclick="previewForm()"
                                data-toggle="modal">
                                <i class="fa-solid fa-circle-check"></i>Preview
                            </a> --}}
                            <a href="/standardized_work/home" class="btn btn-primary m-2">
                                <i class="fa-solid fa-circle-xmark mr-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row px-2">
            <div class="col-lg-12">
                <div class="card card-body my-1 pt-3 pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nama_product"
                                    value="CT" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="3">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="floating-label form-group">
                                <select class="floating-input form-control form-select input"name="ukuran_kapasitas"
                                    id="ukuran_kapasitas">
                                    @php
                                        $selectedValue = old('ukuran_kapasitas');
                                        $manhourData = $manhour
                                            ->where('id_kategori_produk', '3')
                                            ->unique('id_kapasitas');
                                    @endphp
                                    <option value="">Pilih</option>
                                    @foreach ($manhourData as $data)
                                        <option value="{{ $data->kapasitas->ukuran_kapasitas }}"
                                            {{ $selectedValue == $data->kapasitas->ukuran_kapasitas ? 'selected' : '' }}>
                                            {{ $data->kapasitas->ukuran_kapasitas }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Capacity</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nomor_so"
                                    value="{{ old('nomor_so') }}" id="so">
                                <label>SO / No. Prospek</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="id_fg"
                                    value="{{ old('id_fg') }}" id="fg">
                                <label>Kode Finish Good</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-2">
            <div class="col-lg-12  mb-0">
                <div class="row">
                    <div class="col-lg-6" style="padding-right: 5px">
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">COIL MAKING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalJam_value"></span>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_coil_lv" name="hour_coil_lv" value="{{ old('hour_coil_lv') }}"
                                                readonly>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_balutcore_ct">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Balut Core CT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="balutcore_ct" id="balutcore_ct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_cca_balutvt">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Core Coil Assembly
                                                    & Balut VT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="cca_balutvt" id="cca_balutvt">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_buat_pasangshelding">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Buat & Pasang
                                                    Shielding</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="buat_pasangshelding"
                                                    id="buat_pasangshelding">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_gulungcoil_sekunderct">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Gulung Coil
                                                    Sekunder CT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulungcoil_sekunderct"
                                                    id="gulungcoil_sekunderct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_buatcoilprimer_ctmanual">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Buat Coil Primer CT
                                                    Manual</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="buatcoilprimer_ctmanual"
                                                    id="buatcoilprimer_ctmanual">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_buat_coilprimerct_menggunakanmesin">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Buat Coil Primer CT
                                                    Menggunakan Mesin</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="buat_coilprimerct_menggunakanmesin"
                                                    id="buat_coilprimerct_menggunakanmesin">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_koneksi_ctvt">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Koneksi CT Dan VT
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="koneksi_ctvt" id="koneksi_ctvt">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_solder">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Solder</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="solder" id="solder">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_gulungcoilprimer_cutcore">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Gulung Coil Primer
                                                    Cut Core</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulungcoilprimer_cutcore"
                                                    id="gulungcoilprimer_cutcore">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_gulungcoilprimer_nocutcore">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Gulung Coil Primer
                                                    No Cut Core</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulungcoilprimer_nocutcore"
                                                    id="gulungcoilprimer_nocutcore">
                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6" style="padding-left: 5px">
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <div class="row align-items-center">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">MOULD & CASTING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalMouldCasting_value"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_prosesmouldassembly_typect"> 0
                                                </p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Mould
                                                    Assembly Type CT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="prosesmouldassembly_typect"
                                                    id="prosesmouldassembly_typect">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_prosesmouldassembly_typerct"> 0
                                                </p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Mould
                                                    Assembly Type RCT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="prosesmouldassembly_typerct"
                                                    id="prosesmouldassembly_typerct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_pengovenan"> 0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Pengovenan
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="proses_pengovenan" id="proses_pengovenan">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_pembuatanmaterial"> 0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Pembuatan
                                                    Material</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="proses_pembuatanmaterial"
                                                    id="proses_pembuatanmaterial">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_casting"> 0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Casting</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="proses_casting" id="proses_casting">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_demoulding"> 0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses demoulding
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="proses_demoulding" id="proses_demoulding">
                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- Final Assembly  --}}
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">FINAL ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalfinalassembly_value"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_gerindra">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Proses Gerindra</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="proses_gerindra" id="proses_gerindra">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_cat">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Proses Cat</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="proses_cat" name="proses_cat">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_proses_accessories">0</p>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Proses Accessories
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="proses_accessories"
                                                    name="proses_accessories">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_testqc">0</p>
                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Test QC</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="testqc" id="testqc">
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- modal preview  --}}
    {{-- <div class="modal fade preview" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <p class="p-2 bg-warning rounded "><strong><i class="fa-solid fa-warning mr-2"></i> Mohon cek
                                kembali data yang anda input!<strong></p>
                    </div>

                    <div class="row ">
                        <div class="col-md-12">
                            <div class="card rounded-4" style="border-left-color: red; border-left-width: 10px;">
                                <div class="card-body shadow">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h6>Category</h6>
                                            <p class="p-0 m-0" style="color: #d02424" id="preview-category"></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <h6>Kapasitas</h6>
                                            <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas"></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <h6>SO/No.Proyek</h6>
                                            <p class="p-0 m-0" style="color: #d02424" id="preview-so"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-2">
                        <div class="col-lg-12  mb-0">
                            <div class="row">
                                <div class="col-lg-6" style="padding-right: 5px">
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <div class="row align-items-center ">
                                                <div class="input-group input-group-md justify-content-center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">COIL MAKING</span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span type="text" class="input-group-text bg-warning"
                                                            style="width: 3rem" id="preview-totalJam_value"></span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">HOUR</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_balutcore_ct">
                                                            </h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                                            </h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-balutcore_ct"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_coil_hv">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-coil_hv"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_potong_leadwire"></h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Lead Wire</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potong_leadwire"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_potong_isolasi"></h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Isolasi</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potong_isolasi"></h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <div class="row align-items-center">
                                                <div class="input-group input-group-md justify-content-center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">MOULD & CASTING</span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-warning"
                                                            id="preview-totalMouldCasting_value">
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">HOUR</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_hv_moulding"></h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Moulding</h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hv_moulding"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_hv_casting">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Casting</h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hv_casting"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_hv_demoulding"></h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Demoulding</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hv_demoulding"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_lv_bobbin">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">LV
                                                                Bobbin</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-lv_bobbin"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_lv_moulding">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">LV
                                                                Moulding</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-lv_moulding"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_touch_up">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">Touch
                                                                Up</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-touch_up"></h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="padding-left: 5px">
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <div class="row align-items-center ">
                                                <div class="input-group input-group-md justify-content-center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">CORE & ASSEMBLY</span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-warning"
                                                            id="preview-totalCoreCoilAssembly_value"></span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">HOUR</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_type_susun_core">
                                                            </h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">Type
                                                                Susun Core</h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-type_susun_core"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_wiring">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Wiring
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-wiring"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_instal_housing">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Instal
                                                                Housing</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-instal_housing"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>

                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_bongkar_housing">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Bongkar
                                                                Housing</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-bongkar_housing"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_pembuatan_cu_link">
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">
                                                                Pembuatan CU Link
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-pembuatan_cu_link"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_others"></h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Others
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-others"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_accesories"></h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">
                                                                Accessories</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-accesories"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_potong_isolasi_fiber">
                                                            </h6>

                                                        </td>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Isolasi Fiber</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potong_isolasi_fiber"></h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <div class="row align-items-center ">
                                                <div class="input-group input-group-md justify-content-center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">QC Testing</span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-warning"
                                                            id="preview-selectedInfo_qctesting"></span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">HOUR</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_qc_testing">
                                                            </h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">Routine
                                                                Test</h6>
                                                        </td>
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-qc_testing"></h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.id_kategori_produk === 3 &&
                        item.nama_workcenter === selectedWorkcenter &&
                        item.nama_proses === selectedProses
                    );
                });
                $(elementId).empty();
                $(elementId).append('<option value="">-Pilih-</option>');
                $.each(filteredData, function(key, data) {
                    $(elementId).append(
                        '<option value="' + data.nama_tipeproses + '" data-durasi="' + data
                        .durasi_manhour +
                        '" data-workcenter="' + data.nama_workcenter + '">' +
                        data.nama_tipeproses +
                        '</option>'
                    );
                });
            }
            $('#ukuran_kapasitas').on('change', function() {
                var ukuran_kapasitas = $(this).val();
                // console.log(ukuran_kapasitas);
                if (ukuran_kapasitas) {
                    $.ajax({
                        url: '/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/' +
                            ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data) {
                                fillSelect('#balutcore_ct', data, 'BALUT CORE CT',
                                    'COIL MAKING');
                                fillSelect('#cca_balutvt', data,
                                    'CORE COIL ASSEMBLY & BALUT VT', 'COIL MAKING');
                                fillSelect('#buat_pasangshelding', data,
                                    'BUAT & PASANG SHIELDING',
                                    'COIL MAKING');
                                fillSelect('#gulungcoil_sekunderct', data,
                                    'GULUNG COIL SEKUNDER CT',
                                    'COIL MAKING');
                                fillSelect('#buatcoilprimer_ctmanual', data,
                                    'BUAT COIL PRIMER CT MANUAL',
                                    'COIL MAKING');
                                fillSelect('#buat_coilprimerct_menggunakanmesin', data,
                                    'BUAT COIL PRIMER CT MENGGUNAKAN MESIN',
                                    'COIL MAKING');
                                fillSelect('#koneksi_ctvt', data, 'KONEKSI CT DAN VT',
                                    'COIL MAKING');
                                fillSelect('#solder', data, 'SOLDER',
                                    'COIL MAKING');
                                // fillSelect('#potong_isolasi', data, 'GULUNG COIL SEKUNDER VT MANUAL',
                                //     'COIL MAKING');
                                // fillSelect('#potong_isolasi', data, 'GULUNG COIL SEKUNDER VT MENGGUNAKAN MESIN',
                                //     'COIL MAKING');
                                fillSelect('#gulungcoilprimer_cutcore', data,
                                    'GULUNG COIL PRIMER CUT CORE',
                                    'COIL MAKING');
                                fillSelect('#gulungcoilprimer_nocutcore', data,
                                    'GULUNG COIL PRIMER NO CUT CORE',
                                    'COIL MAKING');
                                fillSelect('#prosesmouldassembly_typect', data,
                                    'PROSES MOULD ASSEMBLY TYPE CT',
                                    'MOULD & CASTING');
                                fillSelect('#prosesmouldassembly_typerct', data,
                                    'PROSES MOULD ASSEMBLY TYPE RCT',
                                    'MOULD & CASTING');
                                fillSelect('#proses_pengovenan', data, 'PROSES PENGOVENAN',
                                    'MOULD & CASTING');
                                fillSelect('#proses_pembuatanmaterial', data,
                                    'PROSES PEMBUATAN MATERIAL',
                                    'MOULD & CASTING');
                                fillSelect('#proses_casting', data, 'PROSES CASTING',
                                    'MOULD & CASTING');
                                fillSelect('#proses_demoulding', data, 'PROSES DEMOULDING',
                                    'MOULD & CASTING');
                                // fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
                                //     'CORE COIL ASSEMBLY');
                                fillSelect('#proses_gerindra', data, 'PROSES GERINDA',
                                    'FINAL ASSEMBLY');
                                fillSelect('#proses_cat', data, 'PROSES CAT',
                                    'FINAL ASSEMBLY');
                                fillSelect('#proses_accessories', data, 'PASANG ACESORIS',
                                    'FINAL ASSEMBLY');
                                fillSelect('#testqc', data, 'QC TESTING',
                                    'QC TEST');
                                // fillSelect('#bongkar_housing', data, 'BONGKAR HOUSING',
                                //     'CORE COIL ASSEMBLY');
                                // fillSelect('#pembuatan_cu_link', data, 'PEMBUATAN CU LINK',
                                //     'CORE COIL ASSEMBLY');
                                // fillSelect('#others', data, 'OTHERS', 'CORE COIL ASSEMBLY');
                                // fillSelect('#accesories', data, 'ACCESORIES',
                                //     'CORE COIL ASSEMBLY');
                                // fillSelect('#potong_isolasi_fiber', data,
                                //     'POTONG ISOLASI FIBER', 'CORE COIL ASSEMBLY');
                                // fillSelect('#qc_testing', data, 'ROUNTINE',
                                //     'QC TESTv');
                                $('#balutcore_ct').on('change', function() {
                                    showSelected('balutcore_ct');
                                });
                                $('#cca_balutvt').on('change', function() {
                                    showSelected('cca_balutvt');
                                });
                                $('#buat_pasangshelding').on('change', function() {
                                    showSelected('buat_pasangshelding');
                                });
                                $('#gulungcoil_sekunderct').on('change', function() {
                                    showSelected('gulungcoil_sekunderct');
                                });
                                $('#buatcoilprimer_ctmanual').on('change', function() {
                                    showSelected('buatcoilprimer_ctmanual');
                                });
                                $('#buat_coilprimerct_menggunakanmesin').on('change',
                            function() {
                                    showSelected('buat_coilprimerct_menggunakanmesin');
                                });
                                $('#koneksi_ctvt').on('change', function() {
                                    showSelected('koneksi_ctvt');
                                });
                                $('#solder').on('change', function() {
                                    showSelected('solder');
                                });
                                $('#gulungcoilprimer_cutcore').on('change', function() {
                                    showSelected('gulungcoilprimer_cutcore');
                                });
                                $('#gulungcoilprimer_nocutcore').on('change', function() {
                                    showSelected('gulungcoilprimer_nocutcore');
                                });
                                $('#prosesmouldassembly_typect').on('change', function() {
                                    showSelected('prosesmouldassembly_typect');
                                });
                                $('#prosesmouldassembly_typerct').on('change', function() {
                                    showSelected('prosesmouldassembly_typerct');
                                });
                                $('#proses_pengovenan').on('change', function() {
                                    showSelected('proses_pengovenan');
                                });
                                $('#proses_pembuatanmaterial').on('change', function() {
                                    showSelected('proses_pembuatanmaterial');
                                });
                                $('#proses_casting').on('change', function() {
                                    showSelected('proses_casting');
                                });
                                $('#proses_demoulding').on('change', function() {
                                    showSelected('proses_demoulding');
                                });
                                // $('#type_susun_core').on('change', function() {
                                //     showSelected('type_susun_core');
                                // });
                                $('#proses_gerindra').on('change', function() {
                                    showSelected('proses_gerindra');
                                });
                                $('#proses_cat').on('change', function() {
                                    showSelected('proses_cat');
                                });
                                $('#proses_accessories').on('change', function() {
                                    showSelected('proses_accessories');
                                });
                                $('#testqc').on('change', function() {
                                    showSelected('testqc');
                                });
                                // $('#bongkar_housing').on('change', function() {
                                //     showSelected('bongkar_housing');
                                // });
                                // $('#pembuatan_cu_link').on('change', function() {
                                //     showSelected('pembuatan_cu_link');
                                // });
                                // $('#others').on('change', function() {
                                //     showSelected('others');
                                // });
                                // $('#accesories').on('change', function() {
                                //     showSelected('accesories');
                                // });
                                // $('#potong_isolasi_fiber').on('change', function() {
                                //     showSelected('potong_isolasi_fiber');
                                // });
                                // $('#qc_testing').on('change', function() {
                                //     showSelected('qc_testing');
                                // });
                            } else {
                                resetForm();
                            }
                        },
                        error: function(xhr, status, error) {
                            // console.error('AJAX Request Error:', xhr.responseText);
                            alert(
                                'Terjadi kesalahan saat mengambil data barang. Silakan coba lagi.'
                            );
                        }
                    });
                } else {
                    resetForm();
                }
            });
        });

        function showSelected(target) {
            let selectElements = document.querySelectorAll('select');
            let totalManhour = 0;
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = selectedOption.getAttribute('data-durasi');
                    totalManhour += parseFloat(durasi || 0);
                });
            });
            let totalHourInput = document.getElementById('total_hour');
            totalHourInput.value = totalManhour;
            let select = document.getElementById(target);
            // console.log('Select Element:', select);
            let selectedOptions = Array.from(select.selectedOptions);
            let totalDurasi = 0;
            selectedOptions.forEach(function(selectedOption) {
                let selectedDurasi = selectedOption.getAttribute('data-durasi');
                totalDurasi += parseFloat(selectedDurasi || 0);
            });
            let selectedInfo = document.getElementById("selectedInfo_" + target);
            // console.log('Selected Info Element:', selectedInfo);
            selectedInfo.textContent = " " + totalDurasi;
            // console.log(selectedInfo);
            // console.log(totalDurasi);
        }

        function displayTotalJamCoilMaking() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'COIL MAKING') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            // console.log("Work Center (COIL MAKING):", workcenterInfo);
            let totalJamElement = document.getElementById("totalJam_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }

        function displayTotalJamMouldCasting() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'MOULD & CASTING') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            // console.log("Work Center (MOULD & CASTING):", workcenterInfo);
            let totalJamElement = document.getElementById("totalMouldCasting_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }

        function displayTotalJamCoreCoilAssembly() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'FINAL ASSEMBLY') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            // console.log("Work Center (CORE COIL ASSEMBLY):", workcenterInfo);
            let totalJamElement = document.getElementById("totalfinalassembly_value");
            if (totalJamElement) {
                totalJamElement.textContent = totalJam;
            }
        }

        document.querySelectorAll('select').forEach(function(select) {
            select.addEventListener('change', function() {
                let selectedOption = select.options[select.selectedIndex];
                let workCenter = selectedOption.getAttribute('data-workcenter');
                if (workCenter === 'COIL MAKING') {
                    displayTotalJamCoilMaking();
                } else if (workCenter === 'MOULD & CASTING') {
                    displayTotalJamMouldCasting();
                } else if (workCenter === 'FINAL ASSEMBLY') {
                    displayTotalJamCoreCoilAssembly();
                }
            });
        });
    </script>
    {{-- <script>
        function previewForm() {
            //tampilan hour
            document.getElementById("preview-totalJam_value").innerHTML = document.getElementById("totalJam_value")
                .innerHTML;
            document.getElementById("preview-selectedInfo_balutcore_ct").innerHTML = document.getElementById(
                "selectedInfo_balutcore_ct").innerHTML;
            document.getElementById("preview-selectedInfo_coil_hv").innerHTML = document.getElementById(
                "selectedInfo_coil_hv").innerHTML;
            document.getElementById("preview-selectedInfo_potong_leadwire").innerHTML = document.getElementById(
                "selectedInfo_potong_leadwire").innerHTML;
            document.getElementById("preview-selectedInfo_potong_isolasi").innerHTML = document.getElementById(
                "selectedInfo_potong_isolasi").innerHTML;
            document.getElementById("preview-selectedInfo_hv_moulding").innerHTML = document.getElementById(
                "selectedInfo_hv_moulding").innerHTML;
            document.getElementById("preview-selectedInfo_hv_casting").innerHTML = document.getElementById(
                "selectedInfo_hv_casting").innerHTML;
            document.getElementById("preview-selectedInfo_hv_demoulding").innerHTML = document.getElementById(
                "selectedInfo_hv_demoulding").innerHTML;
            document.getElementById("preview-selectedInfo_lv_bobbin").innerHTML = document.getElementById(
                "selectedInfo_lv_bobbin").innerHTML;
            document.getElementById("preview-selectedInfo_lv_moulding").innerHTML = document.getElementById(
                "selectedInfo_lv_moulding").innerHTML;
            document.getElementById("preview-selectedInfo_touch_up").innerHTML = document.getElementById(
                "selectedInfo_touch_up").innerHTML;
            document.getElementById("preview-selectedInfo_type_susun_core").innerHTML = document.getElementById(
                "selectedInfo_type_susun_core").innerHTML;
            document.getElementById("preview-selectedInfo_wiring").innerHTML = document.getElementById(
                "selectedInfo_wiring").innerHTML;
            document.getElementById("preview-selectedInfo_instal_housing").innerHTML = document.getElementById(
                "selectedInfo_instal_housing").innerHTML;
            document.getElementById("preview-selectedInfo_bongkar_housing").innerHTML = document.getElementById(
                "selectedInfo_bongkar_housing").innerHTML;
            document.getElementById("preview-selectedInfo_pembuatan_cu_link").innerHTML = document.getElementById(
                "selectedInfo_pembuatan_cu_link").innerHTML;
            document.getElementById("preview-selectedInfo_others").innerHTML = document.getElementById(
                "selectedInfo_others").innerHTML;
            document.getElementById("preview-selectedInfo_accesories").innerHTML = document.getElementById(
                "selectedInfo_accesories").innerHTML;
            document.getElementById("preview-selectedInfo_potong_isolasi_fiber").innerHTML = document.getElementById(
                "selectedInfo_potong_isolasi_fiber").innerHTML;
            document.getElementById("preview-totalMouldCasting_value").innerHTML = document.getElementById(
                "totalMouldCasting_value").innerHTML;
            document.getElementById("preview-totalCoreCoilAssembly_value").innerHTML = document.getElementById(
                "totalCoreCoilAssembly_value").innerHTML;

            //tampilan khusus yang checkbox
            document.getElementById('preview-potong_isolasi').innerHTML = '' + [...document.getElementById('potong_isolasi')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-lv_bobbin').innerHTML = '' + [...document.getElementById('lv_bobbin')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-lv_moulding').innerHTML = '' + [...document.getElementById('lv_moulding')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-touch_up').innerHTML = '' + [...document.getElementById('touch_up')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-others').innerHTML = '' + [...document.getElementById('others')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-accesories').innerHTML = '' + [...document.getElementById('accesories')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-potong_isolasi_fiber').innerHTML = '' + [...document.getElementById(
                'potong_isolasi_fiber').selectedOptions].map(option => option.value).join(', ');

            //value setiap inputan
            document.getElementById("preview-category").textContent = document.getElementById("category").value;
            document.getElementById("preview-ukuran_kapasitas").textContent = document.getElementById("ukuran_kapasitas")
                .value;
            document.getElementById("preview-so").textContent = document.getElementById("so").value;
            document.getElementById("preview-balutcore_ct").textContent = document.getElementById("balutcore_ct").value;
            document.getElementById("preview-coil_hv").textContent = document.getElementById("coil_hv").value;
            document.getElementById("preview-potong_leadwire").textContent = document.getElementById("potong_leadwire")
                .value;
            document.getElementById("preview-hv_moulding").textContent = document.getElementById("hv_moulding").value;
            document.getElementById("preview-hv_casting").textContent = document.getElementById("hv_casting").value;
            document.getElementById("preview-hv_demoulding").textContent = document.getElementById("hv_demoulding").value;
            document.getElementById("preview-type_susun_core").textContent = document.getElementById("type_susun_core")
                .value;
            document.getElementById("preview-wiring").textContent = document.getElementById("wiring").value;
            document.getElementById("preview-instal_housing").textContent = document.getElementById("instal_housing").value;
            document.getElementById("preview-bongkar_housing").textContent = document.getElementById("bongkar_housing")
                .value;
            document.getElementById("preview-pembuatan_cu_link").textContent = document.getElementById("pembuatan_cu_link")
                .value;


            // Tampilkan area pratinjau
            document.getElementById("preview").style.display = "block";
        }
    </script> --}}
@endsection
