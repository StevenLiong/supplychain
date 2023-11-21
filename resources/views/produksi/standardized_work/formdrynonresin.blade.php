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
    <form class="login-content floating-label " method="post" action="{{ route('store.drynonresin') }}">
        @csrf
        <div class="row px-2">
            <div class="col-lg-12">
                <!-- Total Hour -->
                <div class="card card-body my-1 py-1">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="alert-title">`````````````````
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
    {{-- <form class="login-content floating-label " method="POST" action="home">
        @csrf
        <div class="row px-2">
            <div class="col-lg-12">
                <!-- Total Hour -->
                <div class="card card-body my-1 py-1">
                    <!-- tampilan total hour pada tiap work center -->
                    <div class="row align-items-center justify-content-center px-3 ">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-left input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-size-lg"><b>TOTAL HOUR</b></span>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text font-size-lg bg-warning"><b>05</b></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                            <button type="reset" class="btn btn-warning m-2">
                                <i class="fa-solid fa-rotate-left mr-2"> </i>Reset
                            </button>
                            <a href="#" class="btn btn-primary m-2" data-target=".preview" onclick="previewForm()"
                                data-toggle="modal">
                                <i class="fa-regular fa-floppy-disk mr-2"></i>Save
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
                                <input class="floating-input form-control" type="text" placeholder="" id="category">
                                <label>Category</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" id="capacity">
                                <label>Capacity</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" id="so">
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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="hour_coilmaking" value="5" disabled>
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
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_coillv" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil LV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="coillv" required="">
                                                    <option>Flat-Konduktor 1</option>
                                                    <option>Flat-Konduktor 2-3</option>
                                                    <option>Flat-Konduktor 4-8</option>
                                                    <option>Flat-Konduktor >8</option>
                                                    <option>Sheet-Konduktor 1</option>
                                                    <option>Sheet-Konduktor 2-3</option>
                                                    <option>Round-Konduktor 1</option>
                                                    <option>Round-Konduktor 2-3</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_coilhv" value="5" disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil HV</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="coilhv" required="">
                                                    <option>Flat-Konduktor 1</option>
                                                    <option>Flat-Konduktor 2-3</option>
                                                    <option>Flat-Konduktor 4-8</option>
                                                    <option>Flat-Konduktor >8</option>
                                                    <option>Round-Konduktor 1</option>
                                                    <option>Round-Konduktor 2-3</option>
                                                    <option>Round-Konduktor 4-8</option>
                                                    <option>Round-Konduktor >8</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_potongleadwire" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Lead Wire</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="potongleadwire" required="">
                                                    <option>Tebal Rail Copper ≥ 10t </option>
                                                    <option>Tebal Rail Copper < 10t</option>
                                                    <option>Coppal Bar</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_potongisolasi" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center "
                                                    style="margin-bottom: 0rem">
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="potongisolasi_Dog_Bone">
                                                        <label class="m-0" for="potongisolasi_Dog_Bone">Dog
                                                            Bone</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="potongisolasi_Inner">
                                                        <label class="m-0" for="potongisolasi_Inner">Inner</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="potongisolasi_Outer">
                                                        <label class="m-0" for="potongisolasi_Outer">Outer</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="potongisolasi_Ganjal_Antar_Section">
                                                        <label class="m-0"
                                                            for="potongisolasi_Ganjal_Antar_Section">Ganjal Antar
                                                            Section</label>
                                                    </div>
                                                </div>
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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="hour_mouldcasting" value="6" disabled>
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
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_hvmoulding" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Moulding</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="hvmoulding" required="">
                                                    <option>Konduktor 1</option>
                                                    <option>Konduktor 2-3</option>
                                                    <option>Konduktor 4-6</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">QC TESTING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="hour_qctesting" value="5" disabled>
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
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_routinetest" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Routine Test </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center "
                                                    style="margin-bottom: 0rem">
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="qctesting_routine_test">
                                                        <label class="m-0" for="qctesting_routine_test">Routine
                                                            Test</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- kanan  -->
                    <div class="col-lg-6" style="padding-left: 5px">
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <!-- tampilan total hour pada tiap work center  -->
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">CORE & ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="hour_coreassembly" value="1" disabled>
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
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_typesusuncore" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Type Susun Core</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="typesusuncore" required="">
                                                    <option>Stacking Inhouse</option>
                                                    <option>Stacking Outsourcing</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_hvconnection" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">HV Connection</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="hvconnection" required="">
                                                    <option>Flat</option>
                                                    <option>Sheet</option>
                                                    <option>Wire Soft</option>
                                                    <option>Rail Copper</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td class="w-20">
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_lvconnection" value="5" disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">LV Connection</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="lvconnection" required="">
                                                    <option>Flat</option>
                                                    <option>Sheet</option>
                                                    <option>Wire Soft</option>
                                                    <option>Rail Copper</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_wiring" value="5" disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Wiring</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="wiring" required="">
                                                    <option selected="" disabled="" value="">Pilih salah satu
                                                    </option>
                                                    <option>Non Complete</option>
                                                    <option>Complete</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_instalhousing" value="5" disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Instal Housing</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="instalhousing" required="">
                                                    <option selected="" disabled="" value="">Dengan Base
                                                    </option>
                                                    <option>Tanpa Base</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_bongkarhousing" value="5" disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Bongkar Housing</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="bongkarhousing" required="">
                                                    <option selected="" disabled="" value="">Dengan Base
                                                    </option>
                                                    <option>Tanpa Base</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_pembuatanculink" value="5"
                                                    disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Pembuatan CU Link
                                                </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" id="pembuatanculink" required="">
                                                    <option selected="" disabled="" value="">HV / LV
                                                        (Standard)</option>
                                                    <option>HV + LV (Standard)</option>
                                                    <option>HV / LV (Non Standard)</option>
                                                    <option>HV + LV (Non Standard)</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_others" value="5" disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Others</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <div
                                                    class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="others_pembuatancubar">
                                                        <label class="m-0" for="others_pembuatancubar">Pembuatan CU
                                                            Bar</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="others_pembuatankoneksihv">
                                                        <label class="m-0" for="others_pembuatankoneksihv">Pembuatan
                                                            Koneksi
                                                            HV</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="others_finishing">
                                                        <label class="m-0" for="others_finishing">Finishing</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="others_assembly">
                                                        <label class="m-0" for="others_assembly">Assembly</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_accessories" value="5" disabled>

                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Accessories</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <div
                                                    class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="accessories_fan">
                                                        <label class="m-0" for="accessories_fan">Fan</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="accessories_oltc">
                                                        <label class="m-0" for="accessories_oltc">OLTC</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="accessories_lem_spacer_block_airgap">
                                                        <label class="m-0"
                                                            for="accessories_lem_spacer_block_airgap">Lem Spacer
                                                            Block/Air Gap</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <!-- tampilan hour dari inputan  -->
                                            <td>
                                                <input type="text" class="border border-dark rounded p-1 text-center"
                                                    style="width:100%;" id="hour_potongisolasifiber" value="5"
                                                    disabled>
                                            </td>
                                            <!-- nama proses-->
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi Fiber
                                                </h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td style="width:500px ">
                                                <div
                                                    class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="potongisolasifiber_pullingboard">
                                                        <label class="m-0"
                                                            for="potongisolasifiber_pullingboard">Pulling Board</label>
                                                    </div>
                                                    <div class="row align-items-center">
                                                        <input type="checkbox" class="checkbox-input mr-1"
                                                            id="potongisolasifiber_fixingpartinsulation">
                                                        <label class="m-0"
                                                            for="potongisolasifiber_fixingpartinsulation">Fixing Part
                                                            Insulation</label>
                                                    </div>
                                                </div>
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
    </form> --}}

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
                                            <p class="p-0 m-0" style="color: #d02424" id="preview-capacity"></p>
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
                                                        <span class="input-group-text bg-warning"
                                                            id="preview-hour_coilmaking"> </span>
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
                                                                id="preview-hour_coillv">XX
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
                                                                id="preview-coillv"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_coilhv">XX
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
                                                                id="preview-coilhv"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                                id="preview-hour_potongleadwire">XX</h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Lead Wire</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-potongleadwire"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_potongisolasi"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Isolasi</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td>
                                                            <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center "
                                                                style="margin-bottom: 0rem">

                                                                <div class="row align-items-center ">
                                                                    <input type="checkbox" class="checkbox-input mr-1"
                                                                        id="preview-potongisolasi_Dog_Bone" disabled>
                                                                    <label for="preview-potongisolasi_Dog_Bone"
                                                                        class="m-0">Dog Bone</label>

                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" class="checkbox-input mr-1"
                                                                        id="preview-potongisolasi_Inner" disabled>
                                                                    <label
                                                                        for="preview-potongisolasi_Inner"class="m-0">Inner</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" class="checkbox-input mr-1"
                                                                        id="preview-potongisolasi_Outer" disabled>
                                                                    <label class="m-0"
                                                                        for="preview-potongisolasi_Outer">Outer</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" class="checkbox-input mr-1"
                                                                        id="preview-potongisolasi_Ganjal_Antar_Section"
                                                                        disabled>
                                                                    <label class="m-0"
                                                                        for="preview-potongisolasi_Ganjal_Antar_Section">Ganjal
                                                                        Antar
                                                                        Section</label>
                                                                </div>
                                                            </div>
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
                                                            id="preview-hour_mouldcasting"><b>05</b></span>
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
                                                                id="preview-hour_hvmoulding">XX</h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                                Moulding</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                                id="preview-hvmoulding"></h6>

                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
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
                                                            id="preview-hour_qctesting"></span>
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
                                                                id="preview-hour_routinetest">
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">Routine
                                                                Test</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <div class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center "
                                                                style="margin-bottom: 0rem">
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-qctesting_routine_test">
                                                                    <label class="m-0"
                                                                        for="preview-qctesting_routine_test">Routine
                                                                        Test</label>
                                                                </div>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- kanan  -->
                                <div class="col-lg-6" style="padding-left: 5px">
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
                                                            id="preview-hour_coreassembly"></span>
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
                                                                id="preview-hour_typesusuncore">XX
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
                                                                id="preview-typesusuncore"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_hvconnection">XX
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">HV Connection</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-hvconnection"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td class="w-20">
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_lvconnection">XX
                                                            </h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td class="w-30">
                                                            <h6 class="border border-dark rounded p-1 text-center">LV Connection
                                                                Susun Core</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td class="w-50">
                                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                                id="preview-lvconnection"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_wiring">XX
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
                                                                id="preview-hour_instalhousing">
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
                                                                id="preview-instalhousing"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->

                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_bongkarhousing">
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
                                                                id="preview-bongkarhousing"></h6>

                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_pembuatanculink">
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
                                                                id="preview-pembuatanculink"></h6>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_others"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Others
                                                            </h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td style="width:500px ">
                                                            <div
                                                                class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-others_pembuatancubar">
                                                                    <label class="m-0"
                                                                        for="preview-others_pembuatancubar">Pembuatan CU
                                                                        Bar</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-others_pembuatankoneksihv">
                                                                    <label class="m-0"
                                                                        for="preview-others_pembuatankoneksihv">Pembuatan
                                                                        Koneksi
                                                                        HV</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-others_finishing">
                                                                    <label class="m-0"
                                                                        for="preview-others_finishing">Finishing</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-others_assembly">
                                                                    <label class="m-0"
                                                                        for="preview-others_assembly">Assembly</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_accessories"></h6>
                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">
                                                                Accessories</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td style="width:500px ">
                                                            <div
                                                                class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-accessories_fan">
                                                                    <label class="m-0"
                                                                        for="preview-accessories_fan">Fan</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-accessories_oltc">
                                                                    <label class="m-0"
                                                                        for="preview-accessories_oltc">OLTC</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-accessories_lem_spacer_block_airgap">
                                                                    <label class="m-0"
                                                                        for="preview-accessories_lem_spacer_block_airgap">Lem
                                                                        Spacer
                                                                        Block/Air Gap</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr !important>
                                                        <!-- tampilan hour dari inputan  -->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center"
                                                                id="preview-hour_potongisolasifiber">
                                                            </h6>

                                                        </td>
                                                        <!-- nama proses-->
                                                        <td>
                                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                                Isolasi Fiber</h6>
                                                        </td>
                                                        <!-- inputan spek -->
                                                        <td style="width:500px ">
                                                            <div
                                                                class="ml-3 form-group checkbox d-inline-block  align-items-center justify-content-center ">
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-potongisolasifiber_pullingboard">
                                                                    <label class="m-0"
                                                                        for="preview-potongisolasifiber_pullingboard">Pulling
                                                                        Board</label>
                                                                </div>
                                                                <div class="row align-items-center">
                                                                    <input type="checkbox" disabled
                                                                        class="checkbox-input mr-1"
                                                                        id="preview-potongisolasifiber_fixingpartinsulation">
                                                                    <label class="m-0"
                                                                        for="preview-potongisolasifiber_fixingpartinsulation">Fixing
                                                                        Part
                                                                        Insulation</label>
                                                                </div>
                                                            </div>
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
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <script>
        function previewForm() {
            // Ambil nilai dari elemen formulir (ngambil id nya)
            var category = document.getElementById("category").value;
            var capacity = document.getElementById("capacity").value;
            var so = document.getElementById("so").value;
            var hour_coilmaking = document.getElementById("hour_coilmaking").value;
            var hour_coillv = document.getElementById("hour_coillv").value;
            var coillv = document.getElementById("coillv").value;
            var hour_coilhv = document.getElementById("hour_coilhv").value;
            var coilhv = document.getElementById("coilhv").value;
            var hour_potongleadwire = document.getElementById("hour_potongleadwire").value;
            var potongleadwire = document.getElementById("potongleadwire").value;
            var hour_potongisolasi = document.getElementById("hour_potongisolasi").value;
            var hour_mouldcasting = document.getElementById("hour_mouldcasting").value;
            var hour_hvmoulding = document.getElementById("hour_hvmoulding").value;
            var hvmoulding = document.getElementById("hvmoulding").value;
            var hour_qctesting = document.getElementById("hour_qctesting").value;
            var hour_routinetest = document.getElementById("hour_routinetest").value;
            var hour_coreassembly = document.getElementById("hour_coreassembly").value;
            var hour_typesusuncore = document.getElementById("hour_typesusuncore").value;
            var typesusuncore = document.getElementById("typesusuncore").value;
            var hour_hvconnection = document.getElementById("hour_hvconnection").value;
            var hvconnection = document.getElementById("hvconnection").value;
            var hour_lvconnection = document.getElementById("hour_lvconnection").value;
            var lvconnection = document.getElementById("lvconnection").value;
            var hour_wiring = document.getElementById("hour_wiring").value;
            var wiring = document.getElementById("wiring").value;
            var hour_instalhousing = document.getElementById("hour_instalhousing").value;
            var instalhousing = document.getElementById("instalhousing").value;
            var hour_bongkarhousing = document.getElementById("hour_bongkarhousing").value;
            var bongkarhousing = document.getElementById("bongkarhousing").value;
            var hour_pembuatanculink = document.getElementById("hour_pembuatanculink").value;
            var pembuatanculink = document.getElementById("pembuatanculink").value;
            var hour_others = document.getElementById("hour_others").value;
            var hour_accessories = document.getElementById("hour_accessories").value;
            var hour_potongisolasifiber = document.getElementById("hour_potongisolasifiber").value;

            // Tampilkan nilai dalam elemen pratinjau
            document.getElementById("preview-category").textContent = category;
            document.getElementById("preview-capacity").textContent = capacity;
            document.getElementById("preview-so").textContent = so;
            document.getElementById("preview-hour_coilmaking").textContent = hour_coilmaking;
            document.getElementById("preview-hour_coillv").textContent = hour_coillv;
            document.getElementById("preview-coillv").textContent = coillv;
            document.getElementById("preview-hour_coilhv").textContent = hour_coilhv;
            document.getElementById("preview-coilhv").textContent = coilhv;
            document.getElementById("preview-hour_potongleadwire").textContent = hour_potongleadwire;
            document.getElementById("preview-potongleadwire").textContent = potongleadwire;
            document.getElementById("preview-hour_potongisolasi").textContent = hour_potongisolasi;
            document.getElementById("preview-hour_mouldcasting").textContent = hour_mouldcasting;
            document.getElementById("preview-hour_hvmoulding").textContent = hour_hvmoulding;
            document.getElementById("preview-hvmoulding").textContent = hvmoulding;
            document.getElementById("preview-hour_qctesting").textContent = hour_qctesting;
            document.getElementById("preview-hour_routinetest").textContent = hour_routinetest;
            document.getElementById("preview-hour_coreassembly").textContent = hour_coreassembly;
            document.getElementById("preview-hour_typesusuncore").textContent = hour_typesusuncore;
            document.getElementById("preview-typesusuncore").textContent = typesusuncore;
            document.getElementById("preview-hour_hvconnection").textContent = hour_hvconnection;
            document.getElementById("preview-hvconnection").textContent = hvconnection;
            document.getElementById("preview-hour_lvconnection").textContent = hour_lvconnection;
            document.getElementById("preview-lvconnection").textContent = lvconnection;
            document.getElementById("preview-hour_wiring").textContent = hour_wiring;
            document.getElementById("preview-wiring").textContent = wiring;
            document.getElementById("preview-hour_instalhousing").textContent = hour_instalhousing;
            document.getElementById("preview-instalhousing").textContent = instalhousing;
            document.getElementById("preview-hour_bongkarhousing").textContent = hour_bongkarhousing;
            document.getElementById("preview-bongkarhousing").textContent = bongkarhousing;
            document.getElementById("preview-pembuatanculink").textContent = pembuatanculink;
            document.getElementById("preview-hour_pembuatanculink").textContent = hour_pembuatanculink;
            document.getElementById("preview-hour_others").textContent = hour_others;
            document.getElementById("preview-hour_accessories").textContent = hour_accessories;
            document.getElementById("preview-hour_potongisolasifiber").textContent = hour_potongisolasifiber;

            //checkbox
            var isChecked = document.getElementById("potongisolasi_Dog_Bone").checked;
            document.getElementById("preview-potongisolasi_Dog_Bone").checked = isChecked;
            var isChecked = document.getElementById("potongisolasi_Inner").checked;
            document.getElementById("preview-potongisolasi_Inner").checked = isChecked;
            var isChecked = document.getElementById("potongisolasi_Outer").checked;
            document.getElementById("preview-potongisolasi_Outer").checked = isChecked;
            var isChecked = document.getElementById("potongisolasi_Ganjal_Antar_Section").checked;
            document.getElementById("preview-potongisolasi_Ganjal_Antar_Section").checked = isChecked;
            var isChecked = document.getElementById("qctesting_routine_test").checked;
            document.getElementById("preview-qctesting_routine_test").checked = isChecked;
            var isChecked = document.getElementById("others_pembuatancubar").checked;
            document.getElementById("preview-others_pembuatancubar").checked = isChecked;
            var isChecked = document.getElementById("others_pembuatankoneksihv").checked;
            document.getElementById("preview-others_pembuatankoneksihv").checked = isChecked;
            var isChecked = document.getElementById("others_finishing").checked;
            document.getElementById("preview-others_finishing").checked = isChecked;
            var isChecked = document.getElementById("others_assembly").checked;
            document.getElementById("preview-others_assembly").checked = isChecked;
            var isChecked = document.getElementById("accessories_fan").checked;
            document.getElementById("preview-accessories_fan").checked = isChecked;
            var isChecked = document.getElementById("accessories_oltc").checked;
            document.getElementById("preview-accessories_oltc").checked = isChecked;
            var isChecked = document.getElementById("accessories_lem_spacer_block_airgap").checked;
            document.getElementById("preview-accessories_lem_spacer_block_airgap").checked = isChecked;
            var isChecked = document.getElementById("potongisolasifiber_pullingboard").checked;
            document.getElementById("preview-potongisolasifiber_pullingboard").checked = isChecked;
            var isChecked = document.getElementById("potongisolasifiber_fixingpartinsulation").checked;
            document.getElementById("preview-potongisolasifiber_fixingpartinsulation").checked = isChecked;


            // Tampilkan area pratinjau
            document.getElementById("preview").style.display = "block";
        }
    </script> --}}
{{-- @endsection --}}
