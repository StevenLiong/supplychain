@extends('produksi.standardized_work.layout')
@section('content')
    <h5 class="text-center text-sm-center text-xs-center my-1 header-title card-title" style="font-size: 30px;color:#d02424;">
        <b>PERHITUNGAN MAN HOUR</b>
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
    <form class="login-content floating-label " method="post" action="{{ route('store.drynonresin') }}">
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
                    {{-- <div class="row">
                        <div class="col-lg-6 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nama_product"
                                    value="Dry Cast Non Resin" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="6">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="floating-label form-group">
                                <select class="floating-input form-control form-select input"name="ukuran_kapasitas"
                                    id="ukuran_kapasitas">
                                    {{-- @php
                                        $selectedValue = old('ukuran_kapasitas');
                                        // fungsi apabila didalam kapasitas terdapat kategori produk yang sesuai
                                        $kapasitasData = $kapasitas->pluck('ukuran_kapasitas');
                                        $manhourData = $manhour
                                            ->where('id_kategori_produk', 4)
                                            ->whereIn('id_kapasitas', $kapasitas->pluck('id'));

                                    @endphp

                                    <option value="">Pilih</option>
                                    @foreach ($kapasitasData as $index => $kapasitas)
                                        <option value="{{ $kapasitas }}"
                                            {{ $selectedValue == $kapasitas ? 'selected' : '' }}>
                                            {{ $kapasitas }}
                                        </option>
                                    @endforeach
                                    @php
                                        $selectedValue = old('ukuran_kapasitas');
                                        $manhourData = $manhour
                                            ->where('id_kategori_produk', '5')
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

                    </div> --}}
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nama_product"
                                    value="Dry Non Resin" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="6">
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
                                            ->where('nama_kategoriproduk', 'Dry Non Resin')
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
                                            {{ $data->ukuran_kapasitas }} - {{ optional($kapasitasFiltered)->id }}
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

                        <div class="col-lg-4 col-sm-6">
                            <label for="Use Housing or Not">Apakah Menggunakan Housing?</label>
                            <div class="custom-control custom-radio custom-radio-color custom-control-inline">
                                <input type="radio" id="customRadio01" name="customRadio-11" class="custom-control-input"
                                    value="Menggunakan Housing">
                                <label class="custom-control-label" for="customRadio01">Ya</label>
                            </div>
                            <div class="custom-control custom-radio custom-radio-color custom-control-inline">
                                <input type="radio" id="customRadio02" name="customRadio-11" class="custom-control-input"
                                    value="Tidak Menggunakan Housing">
                                <label class="custom-control-label" for="customRadio02">Tidak</label>
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
                                                    id="hour_coil_lv" name="hour_coil_lv"
                                                    value="{{ old('hour_coil_lv') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil LV</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="coil_lv" id="coil_lv">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_coil_hv" name="hour_coil_hv"
                                                    value="{{ old('hour_coil_hv') }}" readonly>

                                            </td>
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil HV</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="coil_hv" id="coil_hv">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_potong_leadwire" name="hour_potong_leadwire"
                                                    value="{{ old('hour_potong_leadwire') }}" readonly>

                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Lead Wire
                                                </h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="potong_leadwire" id="potong_leadwire">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_potong_isolasi" name="hour_potong_isolasi"
                                                    value="{{ old('hour_potong_isolasi') }}" readonly>

                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi</h6>
                                            </td>
                                            <td>
                                                <select
                                                    class="form-control border border-dark rounded text-center multiple1"
                                                    style="margin-bottom: 0rem" name="potong_isolasi[]"
                                                    id="potong_isolasi" multiple>
                                                </select>
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
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_moulding_casting" name="hour_moulding_casting"
                                                    value="{{ old('hour_moulding_casting') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Moulding & Casting
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="moulding_casting" id="moulding_casting">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_oven" name="hour_oven" value="{{ old('hour_oven') }}"
                                                    readonly>

                                            </td>
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Oven</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control multiple2" style="width:100%;"
                                                    name="oven[]" id="oven" multiple>

                                                </select>
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
                                            <span class="input-group-text">QC TESTING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_QCTest" name="totalHour_QCTest"
                                                value="{{ old('totalHour_QCTest') }}" readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_qc_testing" name="hour_qc_testing"
                                                    value="{{ old('hour_qc_testing') }}" readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">QC Testing</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class=" form-control border border-dark rounded text-center multiple4"
                                                    style="margin-bottom: 0rem" name="qc_testing[]" id="qc_testing"
                                                    multiple>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6" style="padding-left: 5px">
                        {{-- core & Assembly  --}}
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">CORE & ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_CoreCoilAssembly" name="totalHour_CoreCoilAssembly"
                                                value="{{ old('totalHour_CoreCoilAssembly') }}" readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_type_susun_core" name="hour_type_susun_core"
                                                    value="{{ old('hour_type_susun_core') }}" readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Type Susun Core</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="type_susun_core" id="type_susun_core">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_hv_connection" name="hour_hv_connection"
                                                    value="{{ old('hour_hv_connection') }}" readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">HV Connection</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="hv_connection" name="hv_connection">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_lv_connection" name="hour_lv_connection"
                                                    value="{{ old('hour_lv_connection') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">LV Connection</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="lv_connection" name="lv_connection">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_wiring" name="hour_wiring" value="{{ old('hour_wiring') }}"
                                                    readonly>


                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Wiring</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="wiring" id="wiring">


                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_instal_housing" name="hour_instal_housing"
                                                    value="{{ old('hour_instal_housing') }}" readonly>


                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Instal Housing</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="instal_housing" id="instal_housing">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_bongkar_housing" name="hour_bongkar_housing"
                                                    value="{{ old('hour_bongkar_housing') }}" readonly>


                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Bongkar Housing</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="bongkar_housing" id="bongkar_housing">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_pembuatan_cu_link" name="hour_pembuatan_cu_link"
                                                    value="{{ old('hour_pembuatan_cu_link') }}" readonly>


                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Pembuatan CU Link
                                                </h6>
                                            </td>
                                            <td>

                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="pembuatan_cu_link"
                                                    id="pembuatan_cu_link">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_others" name="hour_others" value="{{ old('hour_others') }}"
                                                    readonly>


                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Others</h6>
                                            </td>
                                            <td style="width:500px ">
                                                <select
                                                    class=" form-control border border-dark rounded text-center multiple3"
                                                    name="others[]" id="others" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_accesories" name="hour_accesories"
                                                    value="{{ old('hour_accesories') }}" readonly>
                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Accessories</h6>
                                            </td>
                                            <td style="width:500px ">
                                                <select
                                                    class=" form-control border border-dark rounded text-center multiple3"
                                                    name="accesories[]" id="accesories" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_potong_isolasi_fiber" name="hour_potong_isolasi_fiber"
                                                    value="{{ old('hour_potong_isolasi_fiber') }}" readonly>

                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi Fiber
                                                </h6>
                                            </td>
                                            <td style="width:500px ">
                                                <select
                                                    class=" form-control border border-dark rounded text-center multiple3"
                                                    name="potong_isolasi_fiber[]" id="potong_isolasi_fiber" multiple>

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
    {{-- @include('standardized_work.modaldrynonresin') --}}
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
                                                            style="width: 3rem" id="preview-totalHour_coil_making"></span>
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
                                                                id="preview-hour_coil_lv">
                                                            </h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                                            </h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-coil_lv"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_coil_hv">
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
                                                                id="preview-hour_potong_leadwire"></h6>
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
                                                                id="preview-hour_potong_isolasi"></h6>
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
                                                            id="preview-totalHour_MouldCasting">
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
                                                                id="preview-hour_mouldingcasting"></h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">
                                                                Moulding Casting</h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-mouldingcasting"></h6>
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
                                                            id="preview-hour_qctesting"></span>
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
                                                                id="preview-hour_qc_testing">
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
                                <div class="col-lg-6" style="padding-left: 5px">
                                    {{-- core and Assembly  --}}
    {{-- <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <div class="row align-items-center ">
                                                <div class="input-group input-group-md justify-content-center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">CORE & ASSEMBLY</span>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-warning"
                                                            id="preview-totalHour_QCTest"></span>
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
                                                                id="preview-hour_type_susun_core">
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
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_hvconnection">
                                                            </h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">HV Connection</h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-hvconnection"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_lvconnection">
                                                            </h6>
                                                        </td>
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">LV Connection</h6>
                                                        </td>
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-lvconnection"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_wiring">
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
                                                                id="preview-hour_instal_housing">
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
                                                                id="preview-hour_bongkar_housing">
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
                                                                id="preview-hour_pembuatan_cu_link">
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
                                                                id="preview-hour_others"></h6>
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
                                                                id="preview-hour_accesories"></h6>
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
                                                                id="preview-hour_potong_isolasi_fiber">
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
                                    </div> --}}
    {{-- </div> --}}

    {{-- </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div> --}}
    {{-- </div>
        </div> --}}
    {{-- </div> --}}
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'Dry Non Resin' &&
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
            // $('#ukuran_kapasitas').on('change', function() {
            //     var ukuran_kapasitas = $(this).val();
            //     if (ukuran_kapasitas) {
            //         $.ajax({
            //             url: '/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/' +
            //                 ukuran_kapasitas,
            //             type: 'GET',
            //             data: {
            //                 '_token': '{{ csrf_token() }}'
            //             },
            //             dataType: 'json',
            //             success: function(data) {
            //                 if (data) {
            //                     fillSelect('#coil_lv', data, 'COIL LV', 'COIL MAKING');
            //                     fillSelect('#coil_hv', data, 'COIL HV', 'COIL MAKING');
            //                     fillSelect('#potong_leadwire', data, 'POTONG LEAD WIRE',
            //                         'COIL MAKING');
            //                     fillSelect('#potong_isolasi', data, 'POTONG ISOLASI',
            //                         'COIL MAKING');
            //                     fillSelect('#moulding_casting', data, 'MOULD & CASTING',
            //                         'MOULD & CASTING');
            //                     fillSelect('#oven', data, 'OVEN',
            //                         'MOULD & CASTING');
            //                     fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#hv_connection', data, 'HV CONNECTION TYPE',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#lv_connection', data, 'LV CONNECTION TYPE',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#wiring', data, 'WIRING', 'CORE & ASSEMBLY');
            //                     fillSelect('#instal_housing', data, 'INSTAL HOUSING',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#bongkar_housing', data, 'BONGKAR HOUSING',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#pembuatan_cu_link', data, 'PEMBUATAN CU LINK',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#others', data, 'OTHERS', 'CORE & ASSEMBLY');
            //                     fillSelect('#accesories', data, 'ACCESSORIES',
            //                         'CORE & ASSEMBLY');
            //                     fillSelect('#potong_isolasi_fiber', data,
            //                         'POTONG ISOLASI FIBER', 'CORE & ASSEMBLY');
            //                     fillSelect('#qc_testing', data, 'QC',
            //                         'QC');
            //                     $('#coil_lv').on('change', function() {
            //                         showSelected('coil_lv');
            //                     });
            //                     $('#coil_hv').on('change', function() {
            //                         showSelected('coil_hv');
            //                     });
            //                     $('#potong_leadwire').on('change', function() {
            //                         showSelected('potong_leadwire');
            //                     });
            //                     $('#potong_isolasi').on('change', function() {
            //                         showSelected('potong_isolasi');
            //                     });
            //                     $('#moulding_casting').on('change', function() {
            //                         showSelected('moulding_casting');
            //                     });
            //                     $('#oven').on('change', function() {
            //                         showSelected('oven');
            //                     });
            //                     $('#type_susun_core').on('change', function() {
            //                         showSelected('type_susun_core');
            //                     });
            //                     $('#hv_connection').on('change', function() {
            //                         showSelected('hv_connection');
            //                     });
            //                     $('#lv_connection').on('change', function() {
            //                         showSelected('lv_connection');
            //                     });
            //                     $('#wiring').on('change', function() {
            //                         showSelected('wiring');
            //                     });
            //                     $('#instal_housing').on('change', function() {
            //                         showSelected('instal_housing');
            //                     });
            //                     $('#bongkar_housing').on('change', function() {
            //                         showSelected('bongkar_housing');
            //                     });
            //                     $('#pembuatan_cu_link').on('change', function() {
            //                         showSelected('pembuatan_cu_link');
            //                     });
            //                     $('#others').on('change', function() {
            //                         showSelected('others');
            //                     });
            //                     $('#accesories').on('change', function() {
            //                         showSelected('accesories');
            //                     });
            //                     $('#potong_isolasi_fiber').on('change', function() {
            //                         showSelected('potong_isolasi_fiber');
            //                     });
            //                     $('#qc_testing').on('change', function() {
            //                         showSelected('qc_testing');
            //                     });
            //                 } else {
            //                     resetForm();
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 alert(
            //                     'Terjadi kesalahan saat mengambil data barang. Silakan coba lagi.'
            //                 );
            //             }
            //         });
            //     } else {
            //         resetForm();
            //     }
            // });
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
                        url: '/standardized_work/Create-Data/Dry-Non-Resin/kapasitas/' + ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data) {
                                previousData = data; // Simpan data sebelumnya
                                fillSelect('#coil_lv', data, 'COIL LV', 'COIL MAKING');
                                fillSelect('#coil_hv', data, 'COIL HV', 'COIL MAKING');
                                fillSelect('#potong_leadwire', data, 'POTONG LEAD WIRE',
                                    'COIL MAKING');
                                fillSelect('#potong_isolasi', data, 'POTONG ISOLASI',
                                    'COIL MAKING');
                                fillSelect('#moulding_casting', data, 'MOULD & CASTING',
                                    'MOULD & CASTING');
                                fillSelect('#oven', data, 'OVEN',
                                    'MOULD & CASTING');
                                fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
                                    'CORE & ASSEMBLY');
                                fillSelect('#hv_connection', data, 'HV CONNECTION TYPE',
                                    'CORE & ASSEMBLY');
                                fillSelect('#lv_connection', data, 'LV CONNECTION TYPE',
                                    'CORE & ASSEMBLY');
                                fillSelect('#wiring', data, 'WIRING', 'CORE & ASSEMBLY');
                                fillSelect('#instal_housing', data, 'INSTAL HOUSING',
                                    'CORE & ASSEMBLY');
                                fillSelect('#bongkar_housing', data, 'BONGKAR HOUSING',
                                    'CORE & ASSEMBLY');
                                fillSelect('#pembuatan_cu_link', data, 'PEMBUATAN CU LINK',
                                    'CORE & ASSEMBLY');
                                fillSelect('#others', data, 'OTHERS', 'CORE & ASSEMBLY');
                                fillSelect('#accesories', data, 'ACCESSORIES',
                                    'CORE & ASSEMBLY');
                                fillSelect('#potong_isolasi_fiber', data,
                                    'POTONG ISOLASI FIBER', 'CORE & ASSEMBLY');
                                fillSelect('#qc_testing', data, 'QC',
                                    'QC');
                                $('#coil_lv').on('change', function() {
                                    showSelected('coil_lv');
                                });
                                $('#coil_hv').on('change', function() {
                                    showSelected('coil_hv');
                                });
                                $('#potong_leadwire').on('change', function() {
                                    showSelected('potong_leadwire');
                                });
                                $('#potong_isolasi').on('change', function() {
                                    showSelected('potong_isolasi');
                                });
                                $('#moulding_casting').on('change', function() {
                                    showSelected('moulding_casting');
                                });
                                $('#oven').on('change', function() {
                                    showSelected('oven');
                                });
                                $('#type_susun_core').on('change', function() {
                                    showSelected('type_susun_core');
                                });
                                $('#hv_connection').on('change', function() {
                                    showSelected('hv_connection');
                                });
                                $('#lv_connection').on('change', function() {
                                    showSelected('lv_connection');
                                });
                                $('#wiring').on('change', function() {
                                    showSelected('wiring');
                                });
                                $('#instal_housing').on('change', function() {
                                    showSelected('instal_housing');
                                });
                                $('#bongkar_housing').on('change', function() {
                                    showSelected('bongkar_housing');
                                });
                                $('#pembuatan_cu_link').on('change', function() {
                                    showSelected('pembuatan_cu_link');
                                });
                                $('#others').on('change', function() {
                                    showSelected('others');
                                });
                                $('#accesories').on('change', function() {
                                    showSelected('accesories');
                                });
                                $('#potong_isolasi_fiber').on('change', function() {
                                    showSelected('potong_isolasi_fiber');
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

            $('input[type="radio"][name="customRadio-11"]').change(function() {
                if ($(this).val() === "Menggunakan Housing") {
                    $('#instal_housing, #bongkar_housing, #wiring').prop('disabled', false);
                } else if ($(this).val() === "Tidak Menggunakan Housing") {
                    $('#instal_housing, #bongkar_housing, #wiring').prop('disabled', true);
                    // Mengatur kembali ke tampilan "pilih" jika sebelumnya dipilih
                    $('#instal_housing, #bongkar_housing, #wiring').prop('checked', false);
                    $('#instal_housing, #bongkar_housing, #wiring, #hour_instal_housing, #hour_bongkar_housing, #hour_wiring')
                        .val('');
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
                    if (workCenterAttr === 'CORE & ASSEMBLY') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_CoreCoilAssembly");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
            }
        }

        function displayTotalJamQCTest() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'QC') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_QCTest");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
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
                } else if (workCenter === 'CORE & ASSEMBLY') {
                    displayTotalJamCoreCoilAssembly();
                } else if (workCenter === 'QC') {
                    displayTotalJamQCTest();
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
    </script>
    <script>
        $(document).ready(function() {
            $(".multiple1").select2({
                placeholder: 'Pilih',
                width: '100%',
                dropdownAutoWidth: true,
                // allowClear: true
            }).on('change', displayTotalJamCoilMaking);
            $(".multiple2").select2({
                placeholder: 'Pilih',
                width: '100%',
                dropdownAutoWidth: true,
                // allowClear: true
            }).on('change', displayTotalJamMouldCasting);
            $(".multiple3").select2({
                placeholder: 'Pilih',
                width: '100%',
                dropdownAutoWidth: true,
                // allowClear: true
            }).on('change', displayTotalJamCoreCoilAssembly);
            $(".multiple4").select2({
                placeholder: 'Pilih',
                width: '100%',
                dropdownAutoWidth: true,
                // allowClear: true
            }).on('change', displayTotalJamQCTest);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk menampilkan total jam
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
            var displayFunctions = [displayTotalJamCoilMaking, displayTotalJamMouldCasting, displayTotalJamCoreCoilAssembly, displayTotalJamQCTest];

            // Pengaturan Select2 untuk setiap elemen
            $.each(selectors, function(index, selector) {
                displayTotalJam(selector, displayFunctions[index]);
            });
        });
    </script>
    {{-- <script>
        function previewForm() {
            //tampilan hour
            document.getElementById("preview-totalHour_coil_making").innerHTML = document.getElementById("totalHour_coil_making")
                .innerHTML;
            document.getElementById("preview-hour_coil_lv").innerHTML = document.getElementById(
                "hour_coil_lv").innerHTML;
            document.getElementById("preview-hour_coil_hv").innerHTML = document.getElementById(
                "hour_coil_hv").innerHTML;
            document.getElementById("preview-hour_potong_leadwire").innerHTML = document.getElementById(
                "hour_potong_leadwire").innerHTML;
            document.getElementById("preview-hour_potong_isolasi").innerHTML = document.getElementById(
                "hour_potong_isolasi").innerHTML;
            document.getElementById("preview-hour_mouldingcasting").innerHTML = document.getElementById(
                "hour_mouldingcasting").innerHTML;
            document.getElementById("preview-hour_type_susun_core").innerHTML = document.getElementById(
                "hour_type_susun_core").innerHTML;
            document.getElementById("preview-hour_lvconnection").innerHTML = document.getElementById(
                "hour_lvconnection").innerHTML;
            document.getElementById("preview-hour_hvconnection").innerHTML = document.getElementById(
                "hour_hvconnection").innerHTML;
            document.getElementById("preview-hour_wiring").innerHTML = document.getElementById(
                "hour_wiring").innerHTML;
            document.getElementById("preview-hour_instal_housing").innerHTML = document.getElementById(
                "hour_instal_housing").innerHTML;
            document.getElementById("preview-hour_bongkar_housing").innerHTML = document.getElementById(
                "hour_bongkar_housing").innerHTML;
            document.getElementById("preview-hour_pembuatan_cu_link").innerHTML = document.getElementById(
                "hour_pembuatan_cu_link").innerHTML;
            document.getElementById("preview-hour_others").innerHTML = document.getElementById(
                "hour_others").innerHTML;
            document.getElementById("preview-hour_accesories").innerHTML = document.getElementById(
                "hour_accesories").innerHTML;
            document.getElementById("preview-hour_potong_isolasi_fiber").innerHTML = document.getElementById(
                "hour_potong_isolasi_fiber").innerHTML;
            document.getElementById("preview-hour_qc_testing").innerHTML = document.getElementById(
                "hour_qc_testing").innerHTML;
            document.getElementById("preview-totalHour_MouldCasting").innerHTML = document.getElementById(
                "totalHour_MouldCasting").innerHTML;
            document.getElementById("preview-totalHour_QCTest").innerHTML = document.getElementById(
                "totalHour_QCTest").innerHTML;

            //tampilan khusus yang checkbox
            document.getElementById('preview-potong_isolasi').innerHTML = '' + [...document.getElementById('potong_isolasi')
                .selectedOptions
            ].map(option => option.value).join(', ');
            document.getElementById('preview-qc_testing').innerHTML = '' + [...document.getElementById('preview-qc_testing')
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
            document.getElementById("preview-coil_lv").textContent = document.getElementById("coil_lv").value;
            document.getElementById("preview-coil_hv").textContent = document.getElementById("coil_hv").value;
            document.getElementById("preview-potong_leadwire").textContent = document.getElementById("potong_leadwire")
                .value;
            document.getElementById("preview-mouldingcasting").textContent = document.getElementById("mouldingcasting").value;
            document.getElementById("preview-type_susun_core").textContent = document.getElementById("type_susun_core")
                .value;
            document.getElementById("preview-lvconnection").textContent = document.getElementById("lvconnection").value;
            document.getElementById("preview-hvconnection").textContent = document.getElementById("hvconnection").value;
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
