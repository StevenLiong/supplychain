@extends('produksi.standardized_work.layout')
@section('content')
    <h5 class="text-center text-sm-center text-xs-center my-1 header-title card-title" style="font-size: 30px;color:#d02424;">
        <b>PERHITUNGAN MAN HOUR CT / VT</b>
    </h5>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="modal fade saveModal" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center font-weight-bold ">
                <p style="font-size: 20px;">Apakah anda yakin ingin menyimpan data ini?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitButton">
                    <i class="fa-regular fa-floppy-disk mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
    <form class="login-content floating-label " method="post" action="{{ route('store.ctvt') }}" style="height: auto;">
        @csrf
        <div class="row px-2">
            <div class="col-lg-12">
                <div class="card card-body my-1 py-1">

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
                            <button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#saveModal">
                                <i class="fa-regular fa-floppy-disk mr-2"></i>Simpan
                            </button>
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
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nama_product"
                                    value="CT/VT" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="3">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input type="text" class="floating-input form-control" name="kd_manhour" id="kd_manhour"
                                    readonly>
                                <label>Kode Man Hour</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <select class="floating-input form-control form-select input" name="ukuran_kapasitas"
                                    id="ukuran_kapasitas">
                                    <option value="" disabled selected>Pilih</option>
                                    @php
                                        $selectedValue = old('ukuran_kapasitas');
                                        $manhourData = $manhour
                                            ->where('nama_kategoriproduk', 'CTVT')
                                            ->unique('ukuran_kapasitas');
                                    @endphp
                                    @foreach ($manhourData as $data)
                                        @php
                                            $kapasitasFiltered = $kapasitas
                                                ->where('ukuran_kapasitas', $data->ukuran_kapasitas)
                                                ->first();
                                        @endphp
                                        <option value="{{ $data->ukuran_kapasitas }}"
                                            data-id="{{ optional($kapasitasFiltered)->id }}"
                                            {{ $selectedValue == $data->ukuran_kapasitas ? 'selected' : '' }}>
                                            {{ $data->ukuran_kapasitas }}
                                        </option>
                                    @endforeach

                                </select>
                                <label>Capacity</label>
                            </div>

                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nomor_so"
                                    value="{{ old('nomor_so') }}" id="so"
                                    oninput="this.value = this.value.toUpperCase()">
                                <label>SO / No. Prospek</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_coil_making" name="totalHour_coil_making"
                                                value="{{ old('totalHour_coil_making') }}" readonly>

                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_balut_core_ct" name="hour_balut_core_ct"
                                                    value="{{ old('hour_balut_core_ct') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Balut core CT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="balut_core_ct" id="balut_core_ct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_cca_balutvt" name="hour_cca_balutvt"
                                                    value="{{ old('hour_cca_balutvt') }}" readonly>
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
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_buat_pasang_shelding" name="hour_buat_pasang_shelding"
                                                    value="{{ old('hour_buat_pasang_shelding') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Buat & Pasang
                                                    Shielding</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="buat_pasang_shelding"
                                                    id="buat_pasang_shelding">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_gulung_coil_sekunder_ct" name="hour_gulung_coil_sekunder_ct"
                                                    value="{{ old('hour_gulung_coil_sekunder_ct') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Gulung Coil
                                                    Sekunder CT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulung_coil_sekunder_ct"
                                                    id="gulung_coil_sekunder_ct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_buat_coil_primer_ct_manual" name="hour_buat_coil_primer_ct_manual"
                                                    value="{{ old('hour_buat_coil_primer_ct_manual') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Buat Coil Primer CT
                                                    Manual</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="buat_coil_primer_ct_manual"
                                                    id="buat_coil_primer_ct_manual">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_buat_coil_primer_ct_mesin"
                                                    name="hour_buat_coil_primer_ct_mesin"
                                                    value="{{ old('hour_buat_coil_primer_ct_mesin') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Buat Coil Primer CT
                                                    Menggunakan Mesin</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="buat_coil_primer_ct_mesin"
                                                    id="buat_coil_primer_ct_mesin">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_conect_ct_vt" name="hour_conect_ct_vt"
                                                    value="{{ old('hour_conect_ct_vt') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Koneksi CT Dan VT
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="conect_ct_vt" id="conect_ct_vt">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_solder" name="hour_solder" value="{{ old('hour_solder') }}"
                                                    readonly>
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
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_gulungcoil_vt_manual" name="hour_gulungcoil_vt_manual"
                                                    value="{{ old('hour_gulungcoil_vt_manual') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">
                                                    gulungcoil_vt_manual</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulungcoil_vt_manual"
                                                    id="gulungcoil_vt_manual">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_gulungcoil_vt_mesin" name="hour_gulungcoil_vt_mesin"
                                                    value="{{ old('hour_gulungcoil_vt_mesin') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">gulungcoil_vt_mesin
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulungcoil_vt_mesin"
                                                    id="gulungcoil_vt_mesin">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_gulung_coil_primer_cutcore"
                                                    name="hour_gulung_coil_primer_cutcore"
                                                    value="{{ old('hour_gulung_coil_primer_cutcore') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Gulung Coil Primer
                                                    Cut Core</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulung_coil_primer_cutcore"
                                                    id="gulung_coil_primer_cutcore">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_gulung_coil_primer_nocutcor"
                                                    name="hour_gulung_coil_primer_nocutcor"
                                                    value="{{ old('hour_gulung_coil_primer_nocutcor') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Gulung Coil Primer
                                                    No Cut Core</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="gulung_coil_primer_nocutcor"
                                                    id="gulung_coil_primer_nocutcor">
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
                                            <span class="input-group-text">Mould & Casting</span>
                                        </div>
                                        <div class="input-group-append">

                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_MouldCasting" name="totalHour_MouldCasting"
                                                value="{{ old('totalHour_MouldCasting') }}" readonly>

                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_mould_assembly_ct"
                                                    name="hour_mould_assembly_ct"
                                                    value="{{ old('hour_mould_assembly_ct') }}" readonly>
                                            </td>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Mould
                                                    Assembly Type CT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="mould_assembly_ct"
                                                    id="mould_assembly_ct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_prosesmouldassembly_typevt"
                                                    name="hour_prosesmouldassembly_typevt"
                                                    value="{{ old('hour_prosesmouldassembly_typevt') }}" readonly>
                                            </td>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">
                                                    prosesmouldassembly_typevt</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="prosesmouldassembly_typevt"
                                                    id="prosesmouldassembly_typevt">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_mould_assembly_rct"
                                                    name="hour_mould_assembly_rct"
                                                    value="{{ old('hour_mould_assembly_rct') }}" readonly>
                                            </td>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Mould
                                                    Assembly Type RCT</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="mould_assembly_rct"
                                                    id="mould_assembly_rct">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_oven" name="hour_oven"
                                                    value="{{ old('hour_oven') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Pengovenan
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="oven" id="oven">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_pembuatan_material"
                                                    name="hour_pembuatan_material"
                                                    value="{{ old('hour_pembuatan_material') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Pembuatan
                                                    Material</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="pembuatan_material"
                                                    id="pembuatan_material">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_casting" name="hour_casting"
                                                    value="{{ old('hour_casting') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses Casting</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="casting" id="casting">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_demoulding" name="hour_demoulding"
                                                    value="{{ old('hour_demoulding') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Proses demoulding
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="demoulding" id="demoulding">
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
                                            <span class="input-group-text">Final Assembly</span>
                                        </div>

                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_FinalAssembly" name="totalHour_FinalAssembly"
                                                value="{{ old('totalHour_FinalAssembly') }}" readonly>

                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_gerinda" name="hour_gerinda"
                                                    value="{{ old('hour_gerinda') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Proses Gerinda</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="gerinda" id="gerinda">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_cat" name="hour_cat"
                                                    value="{{ old('hour_cat') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Proses Cat</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="cat" name="cat">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_accessoris" name="hour_accessoris"
                                                    value="{{ old('hour_accessoris') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Proses accessoris
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="accessoris"
                                                    name="accessoris">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_qc_testing" name="hour_qc_testing" value="{{ old('hour_qc_testing') }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Test QC</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="qc_testing" id="qc_testing">
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


    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'CTVT' &&
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
            var previousData; // Deklarasikan variabel previousData di luar fungsi

            $(document).ready(function() {
                loadData(); // Panggil fungsi loadData saat dokumen siap
                $('#ukuran_kapasitas').on('change', function() {
                    loadData(); // Panggil loadData saat perubahan terjadi pada select
                });
            });

            function loadData() {
                var ukuran_kapasitas = $('#ukuran_kapasitas').val();
                if (ukuran_kapasitas) {
                    $.ajax({
                        url: '/standardized_work/Create-Data/CtVt/kapasitas/' + ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data) {
                                previousData = data; // Simpan data sebelumnya
                                fillSelect('#balut_core_ct', data, 'Balut core CT',
                                    'Coil CTVT');
                                fillSelect('#cca_balutvt', data,
                                    'Core coil assembly & balut VT', 'Coil CTVT');
                                fillSelect('#buat_pasang_shelding', data,
                                    'Buat & pasang shielding',
                                    'Coil CTVT');
                                fillSelect('#gulung_coil_sekunder_ct', data,
                                    'Gulung coil sekunder CT',
                                    'Coil CTVT');
                                fillSelect('#buat_coil_primer_ct_manual', data,
                                    'Buat coil primer CT manual',
                                    'Coil CTVT');
                                fillSelect('#buat_coil_primer_ct_mesin', data,
                                    'Buat coil primer CT menggunakan mesin',
                                    'Coil CTVT');
                                fillSelect('#conect_ct_vt', data, 'Koneksi CT dan VT',
                                    'Coil CTVT');
                                fillSelect('#solder', data, 'Solder',
                                    'Coil CTVT');
                                fillSelect('#gulungcoil_vt_manual', data,
                                    'Gulung coil sekunder VT manual',
                                    'Coil CTVT');
                                fillSelect('#gulungcoil_vt_mesin', data,
                                    'Gulung coil sekunder VT menggunakan mesin',
                                    'Coil CTVT');
                                fillSelect('#gulung_coil_primer_cutcore', data,
                                    'Gulung coil primer cut core',
                                    'Coil CTVT');
                                fillSelect('#gulung_coil_primer_nocutcor', data,
                                    'Gulung coil primer no cut core',
                                    'Coil CTVT');
                                fillSelect('#mould_assembly_ct', data,
                                    'Proses mould assembly type CT',
                                    'Mould & Casting');
                                fillSelect('#prosesmouldassembly_typevt', data,
                                    'Proses mould assembly type VT',
                                    'Mould & Casting');
                                fillSelect('#mould_assembly_rct', data,
                                    'Proses mould assembly type RCT',
                                    'Mould & Casting');
                                fillSelect('#oven', data, 'Proses pengovenan',
                                    'Mould & Casting');
                                fillSelect('#pembuatan_material', data,
                                    'Proses pembuatan material',
                                    'Mould & Casting');
                                fillSelect('#casting', data, 'Proses casting',
                                    'Mould & Casting');
                                fillSelect('#demoulding', data, 'Proses demoulding',
                                    'Mould & Casting');
                                fillSelect('#gerinda', data, 'Proses gerinda',
                                    'Final Assembly');
                                fillSelect('#cat', data, 'Proses cat',
                                    'Final Assembly');
                                fillSelect('#accessoris', data, 'Pasang acesoris',
                                    'Final Assembly');
                                fillSelect('#qc_testing', data, 'Test QC',
                                    'QC');
                                $('#balut_core_ct').on('change', function() {
                                    showSelected('balut_core_ct');
                                });
                                $('#cca_balutvt').on('change', function() {
                                    showSelected('cca_balutvt');
                                });
                                $('#buat_pasang_shelding').on('change', function() {
                                    showSelected('buat_pasang_shelding');
                                });
                                $('#gulung_coil_sekunder_ct').on('change', function() {
                                    showSelected('gulung_coil_sekunder_ct');
                                });
                                $('#buat_coil_primer_ct_manual').on('change', function() {
                                    showSelected('buat_coil_primer_ct_manual');
                                });
                                $('#buat_coil_primer_ct_mesin').on('change',
                                    function() {
                                        showSelected('buat_coil_primer_ct_mesin');
                                    });
                                $('#conect_ct_vt').on('change', function() {
                                    showSelected('conect_ct_vt');
                                });
                                $('#solder').on('change', function() {
                                    showSelected('solder');
                                });
                                $('#gulung_coil_primer_cutcore').on('change', function() {
                                    showSelected('gulung_coil_primer_cutcore');
                                });
                                $('#gulung_coil_primer_nocutcor').on('change', function() {
                                    showSelected('gulung_coil_primer_nocutcor');
                                });
                                $('#gulungcoil_vt_mesin').on('change', function() {
                                    showSelected('gulungcoil_vt_mesin');
                                });
                                $('#prosesmouldassembly_typevt').on('change', function() {
                                    showSelected('prosesmouldassembly_typevt');
                                });
                                $('#gulungcoil_vt_manual').on('change', function() {
                                    showSelected('gulungcoil_vt_manual');
                                });
                                $('#mould_assembly_ct').on('change', function() {
                                    showSelected('mould_assembly_ct');
                                });
                                $('#mould_assembly_rct').on('change', function() {
                                    showSelected('mould_assembly_rct');
                                });
                                $('#oven').on('change', function() {
                                    showSelected('oven');
                                });
                                $('#pembuatan_material').on('change', function() {
                                    showSelected('pembuatan_material');
                                });
                                $('#casting').on('change', function() {
                                    showSelected('casting');
                                });
                                $('#demoulding').on('change', function() {
                                    showSelected('demoulding');
                                });
                                $('#gerinda').on('change', function() {
                                    showSelected('gerinda');
                                });
                                $('#cat').on('change', function() {
                                    showSelected('cat');
                                });
                                $('#accessoris').on('change', function() {
                                    showSelected('accessoris');
                                });
                                $('#qc_testing').on('change', function() {
                                    showSelected('qc_testing');
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            if (previousData) {}
                        }
                    });
                }
            }
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
            let selectedOptions = Array.from(select.selectedOptions);
            let totalDurasi = 0;
            selectedOptions.forEach(function(selectedOption) {
                let selectedDurasi = selectedOption.getAttribute('data-durasi');
                totalDurasi += parseFloat(selectedDurasi || 0);
            });
            let hour = document.getElementById("hour_" + target);
            hour.value = totalDurasi;
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
                    if (workCenterAttr === 'Coil CTVT') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_coil_making");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
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
                    if (workCenterAttr === 'Mould & Casting') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_MouldCasting");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
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
                    if (workCenterAttr === 'Final Assembly') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_FinalAssembly");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
            }
        }

        // function displayTotalJamQCTest() {
        //     let selectElements = document.querySelectorAll('select');
        //     let totalJam = 0;
        //     let workcenterInfo = {};
        //     selectElements.forEach(function(select) {
        //         let selectedOptions = Array.from(select.selectedOptions);
        //         selectedOptions.forEach(function(selectedOption) {
        //             let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
        //             let workCenterAttr = selectedOption.getAttribute('data-workcenter');
        //             if (workCenterAttr === 'QC') {
        //                 totalJam += durasi;
        //                 if (!workcenterInfo[workCenterAttr]) {
        //                     workcenterInfo[workCenterAttr] = durasi;
        //                 } else {
        //                     workcenterInfo[workCenterAttr] += durasi;
        //                 }
        //             }
        //         });
        //     });
        //     let totalJamElement = document.getElementById("totalHour_QCTest");
        //     if (totalJamElement) {
        //         totalJamElement.value = totalJam;
        //     }
        // }
        document.querySelectorAll('select').forEach(function(select) {
            select.addEventListener('change', function() {
                let selectedOption = select.options[select.selectedIndex];
                let workCenter = selectedOption.getAttribute('data-workcenter');
                if (workCenter === 'Coil CTVT') {
                    displayTotalJamCoilMaking();
                } else if (workCenter === 'Mould & Casting') {
                    displayTotalJamMouldCasting();
                } else if (workCenter === 'Final Assembly') {
                    displayTotalJamCoreCoilAssembly();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            function generateKdManhour() {
                var kategori = document.getElementById('kategori').value;
                var nomor_so = document.getElementById('so').value.toUpperCase();
                var selectedOption = document.getElementById('ukuran_kapasitas').options[document.getElementById(
                    'ukuran_kapasitas').selectedIndex];
                var kapasitasId = selectedOption.getAttribute('data-id');
                var nomorSo = nomor_so.replace(/[\/-]/g, '');

                nomorSo = nomorSo.slice(0, 10);

                var remainingLength = 14 - (kategori.length + String(kapasitasId).length);

                nomorSo = nomorSo.slice(0, remainingLength);

                var kapasitasIdString = String(kapasitasId).padStart(3, '0').slice(-3);
                var nomorSoString = nomorSo.padEnd(10, '0');
                var kdManhour = kategori + kapasitasIdString + nomorSoString;

                return kdManhour;
            }
            document.getElementById('kd_manhour').value = generateKdManhour();

            document.getElementById('kategori').addEventListener('change', function() {
                document.getElementById('kd_manhour').value = generateKdManhour();
            });

            document.getElementById('ukuran_kapasitas').addEventListener('change', function() {
                document.getElementById('kd_manhour').value = generateKdManhour();
            });

            document.getElementById('so').addEventListener('input', function() {
                document.getElementById('kd_manhour').value = generateKdManhour();
            });
        });
        document.getElementById("submitButton").addEventListener("click", function() {
            document.querySelector("form").submit();
        });
    </script>
    <script>
        $(document).ready(function() {
            function displayTotalJam(selector, displayFunction) {
                $(selector).select2({
                    placeholder: 'Pilih',
                    width: '100%',
                    allowClear: true,
                    maximumSelectionLength: Infinity
                }).on('change', displayFunction);
            }

            // Daftar kelas selector dan fungsi tampilan total jam yang sesuai
            var selectors = [".multiple1", ".multiple2", ".multiple3", ".multiple4"];
            var displayFunctions = [displayTotalJamCoilMaking, displayTotalJamMouldCasting,
                displayTotalJamCoreCoilAssembly, displayTotalJamQCTest
            ];

            // Pengaturan Select2 untuk setiap elemen
            $.each(selectors, function(index, selector) {
                displayTotalJam(selector, displayFunctions[index]);
            });
        });
    </script>
@endsection

