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

    <form class="login-content floating-label " method="post" action="{{ route('store.dryresin') }}">
        @csrf
        <div class="row px-2">
            <div class="col-lg-12">
                <!-- Total Hour -->
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
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <!-- tampilan total hour pada tiap work center -->
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
                            <button type="submit" class="btn btn-primary m-2" > <i class="fa-regular fa-floppy-disk mr-2"></i>Save</button>
                            <a href="#" class="btn btn-info m-2" data-target=".preview" onclick="previewForm()"
                                data-toggle="modal">
                                <i class="fa-solid fa-circle-check"></i>Preview
                            </a>
                            <a href="/" class="btn btn-primary m-2">
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
                    <!-- head input  -->
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nama_product"
                                    value="Dry Cast Resin" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="5">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <select class="floating-input form-control form-select input"name="ukuran_kapasitas"
                                    id="ukuran_kapasitas">
                                    @php
                                        $selectedValue = old('ukuran_kapasitas');
                                        $manhourData = $manhour->where('id_kategori_produk', '5')->unique('ukuran_kapasitas');
                                    @endphp
                                    <option value="">Pilih</option>
                                    @foreach ($manhourData as $data)
                                        <option value="{{ $data->ukuran_kapasitas }}"
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
                                    value="{{ old('nomor_so') }}" id="so">
                                <label>SO / No. Prospek</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-2">
            <div class="col-lg-12  mb-0">
                <div class="row">
                    <!-- kiri  -->
                    <div class="col-lg-6" style="padding-right: 5px">
                        <!--Coil Making  -->
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">COIL MAKING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalJam_value"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p class="border border-dark rounded text-center" style="width:100%;"
                                                    id="selectedInfo_coil_lv">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil LV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select
                                                    class="form-control form-select input border border-dark rounded text-center"
                                                    style="height: 33px;" name="coil_lv" id="coil_lv">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_coil_hv">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil HV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="coil_hv" id="coil_hv">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_potong_leadwire">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Lead Wire
                                                </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="potong_leadwire" id="potong_leadwire">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_potong_isolasi">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class="form-control border border-dark rounded text-center "
                                                    style="margin-bottom: 0rem" name="potong_isolasi[]"
                                                    id="potong_isolasi" multiple>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!-- Mould & Casting  -->
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
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
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_hv_moulding"> 0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Moulding</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;"name="hv_moulding" id="hv_moulding">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_hv_casting">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Casting</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="hv_casting" id="hv_casting">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_hv_demoulding">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Demoulding</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="hv_demoulding" id="hv_demoulding">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;"id="selectedInfo_lv_bobbin">0</p>
                                                {{-- <h6 class="border border-dark rounded p-1 text-center"></h6> --}}
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">LV Bobbin</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    name="lv_bobbin[]" id="lv_bobbin" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_lv_moulding">0</p>
                                                {{-- <h6 class="border border-dark rounded p-1 text-center"></h6> --}}
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">LV Moulding</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    name="lv_moulding[]" id="lv_moulding" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_touch_up">0</p>
                                                {{-- <h6 class="border border-dark rounded p-1 text-center"></h6> --}}
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Touch Up</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    name="touch_up[]" id="touch_up" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- kanan  -->
                    <div class="col-lg-6" style="padding-left: 5px">
                        {{-- core & Assembly  --}}
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">CORE & ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalCoreCoilAssembly_value"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_type_susun_core">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Type Susun Core</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="type_susun_core" id="type_susun_core">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_wiring">0</p>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Wiring</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="wiring" id="wiring">


                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_instal_housing">0</p>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Instal Housing</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="instal_housing" id="instal_housing">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_bongkar_housing">0</p>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Bongkar Housing</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="bongkar_housing" id="bongkar_housing">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_pembuatan_cu_link">0</p>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Pembuatan CU Link
                                                </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="pembuatan_cu_link"
                                                    id="pembuatan_cu_link">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_others">0</p>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Others</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    name="others[]" id="others" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_accesories"p>0</p>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Accessories</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    name="accesories[]" id="accesories" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_potong_isolasi_fiber">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi Fiber
                                                </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    name="potong_isolasi_fiber[]" id="potong_isolasi_fiber" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- qc testing  --}}
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">QC TESTING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalQCTest_value"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">HOUR</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- kolom isi  -->
                                <div class="align-items-center justify-content-left pt-1 px-1">
                                    <table class="w-100">
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <p type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="selectedInfo_routine_test">0</p>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Routine Test</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="margin-bottom: 0rem" name="routine_test[]" id="routine_test"
                                                    multiple>

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
    {{-- @include('standardized_work.modaldrycastresin') --}}

    <div class="modal fade preview" tabindex="-1" style="display: none;" aria-hidden="true">
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
                                <!-- kiri  -->
                                <div class="col-lg-6" style="padding-right: 5px">
                                    <!--modal Coil Making  -->
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <!-- tampilan total hour pada tiap work center  -->
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
                                            <!-- kolom isi  -->
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_coil_lv">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                                            </h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-coil_lv"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_coil_hv">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                                            </h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-coil_hv"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_potong_leadwire"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Lead Wire</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potong_leadwire"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_potong_isolasi"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Isolasi</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potong_isolasi"></h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- modal Mould & Casting  -->
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <!-- tampilan total hour pada tiap work center  -->
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
                                            <!-- kolom isi  -->
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_hv_moulding"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Moulding</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hv_moulding"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_hv_casting">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Casting</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hv_casting"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_hv_demoulding"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Demoulding</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hv_demoulding"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_lv_bobbin">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">LV
                                                                Bobbin</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-lv_bobbin"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_lv_moulding">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">LV
                                                                Moulding</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-lv_moulding"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_touch_up">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center">Touch
                                                                Up</h6>
                                                        </td>
                                                        <!-- inputan spek -->
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
                                <!-- kanan  -->
                                <div class="col-lg-6" style="padding-left: 5px">
                                    {{-- core and Assembly  --}}
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <!-- tampilan total hour pada tiap work center  -->
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
                                            <!-- kolom isi  -->
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_type_susun_core">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">Type
                                                                Susun Core</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-type_susun_core"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_wiring">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Wiring
                                                            </h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-wiring"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_instal_housing">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Instal
                                                                Housing</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-instal_housing"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->

                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_bongkar_housing">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Bongkar
                                                                Housing</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-bongkar_housing"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_pembuatan_cu_link">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">
                                                                Pembuatan CU Link
                                                            </h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-pembuatan_cu_link"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_others"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Others
                                                            </h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-others"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_accesories"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">
                                                                Accessories</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-accesories"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_potong_isolasi_fiber">
                                                            </h6>

                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Isolasi Fiber</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potong_isolasi_fiber"></h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- qc testing  --}}
                                    <div class="card card-body my-1 py-1">
                                        <div style="padding: 5px;">
                                            <!-- tampilan total hour pada tiap work center  -->
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
                                            <!-- kolom isi  -->
                                            <div class="align-items-center justify-content-left pt-1 px-1">
                                                <table class="w-100">
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-selectedInfo_routinetest">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">Routine
                                                                Test</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-routinetest"></h6>
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
    </div>


    <script>
        function previewForm() {
            //tampilan hour
            document.getElementById("preview-totalJam_value").innerHTML = document.getElementById("totalJam_value")
                .innerHTML;
            document.getElementById("preview-selectedInfo_coil_lv").innerHTML = document.getElementById(
                "selectedInfo_coil_lv").innerHTML;
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
            document.getElementById("preview-coil_lv").textContent = document.getElementById("coil_lv").value;
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
    </script>
@endsection
