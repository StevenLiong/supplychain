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
                            <button type="submit" class="btn btn-primary m-2"> <i
                                    class="fa-regular fa-floppy-disk mr-2"></i>Save</button>
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
                        <div class="col-lg-6 col-sm-6">
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
                        <div class="col-lg-6 col-sm-6">
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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem" id="totalHour_coil_making" name="totalHour_coil_making" value="{{ old('totalHour_coil_making') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_coil_lv" name="hour_coil_lv" value="{{ old('hour_coil_lv') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_coil_hv" name="hour_coil_hv" value="{{ old('hour_coil_hv') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_potong_leadwire" name="hour_potong_leadwire" value="{{ old('hour_potong_leadwire') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_potong_isolasi" name="hour_potong_isolasi" value="{{ old('hour_potong_isolasi') }}"  readonly>
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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem" id="totalHour_MouldCasting" name="totalHour_MouldCasting" value="{{ old('totalHour_MouldCasting') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_hv_moulding" name="hour_hv_moulding" value="{{ old('hour_hv_moulding') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_hv_casting" name="hour_hv_casting" value="{{ old('hour_hv_casting') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_hv_demoulding" name="hour_hv_demoulding" value="{{ old('hour_hv_demoulding') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_lv_bobbin" name="hour_lv_bobbin" value="{{ old('hour_lv_bobbin') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_lv_moulding" name="hour_lv_moulding" value="{{ old('hour_lv_moulding') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_touch_up" name="hour_touch_up" value="{{ old('hour_touch_up') }}"  readonly>

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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem" id="totalHour_CoreCoilAssembly" name="totalHour_CoreCoilAssembly" value="{{ old('totalHour_CoreCoilAssembly') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_type_susun_core" name="hour_type_susun_core" value="{{ old('hour_type_susun_core') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_wiring" name="hour_wiring" value="{{ old('hour_wiring') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_instal_housing" name="hour_instal_housing" value="{{ old('hour_instal_housing') }}"  readonly>


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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_bongkar_housing" name="hour_bongkar_housing" value="{{ old('hour_bongkar_housing') }}"  readonly>


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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_pembuatan_cu_link" name="hour_pembuatan_cu_link" value="{{ old('hour_pembuatan_cu_link') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_others" name="hour_others" value="{{ old('hour_others') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_accesories" name="hour_accesories" value="{{ old('hour_accesories') }}"  readonly>

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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_potong_isolasi_fiber" name="hour_potong_isolasi_fiber" value="{{ old('hour_potong_isolasi_fiber') }}"  readonly>

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
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem" id="totalHour_QCTest" name="totalHour_QCTest" value="{{ old('totalHour_QCTest') }}"  readonly>
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
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                id="hour_qc_testing" name="hour_qc_testing" value="{{ old('hour_qc_testing') }}"  readonly>

                                            </td>
                                            <!-- nama proses-->
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Routine Test</h6>
                                            </td>
                                            <!-- inputan spek -->
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
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
                                                            style="width: 3rem" id="preview-totalHour_coil_making"></span>
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
                                                                id="preview-hour_coil_lv">
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
                                                                id="preview-hour_coil_hv">
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
                                                                id="preview-hour_potong_leadwire"></h6>
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
                                                                id="preview-hour_potong_isolasi"></h6>
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
                                                            id="preview-totalHour_MouldCasting">
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
                                                                id="preview-hour_hv_moulding"></h6>
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
                                                                id="preview-hour_hv_casting">
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
                                                                id="preview-hour_hv_demoulding"></h6>
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
                                                                id="preview-hour_lv_bobbin">
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
                                                                id="preview-hour_lv_moulding">
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
                                                                id="preview-hour_touch_up">
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
                                                            id="preview-totalHour_CoreCoilAssembly"></span>
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
                                                                id="preview-hour_type_susun_core">
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
                                                                id="preview-hour_wiring">
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
                                                                id="preview-hour_instal_housing">
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
                                                                id="preview-hour_bongkar_housing">
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
                                                                id="preview-hour_pembuatan_cu_link">
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
                                                                id="preview-hour_others"></h6>
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
                                                                id="preview-hour_accesories"></h6>
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
                                                                id="preview-hour_potong_isolasi_fiber">
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
                                                                id="preview-hour_qc_testing">
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'DRY TYPE RESIN' &&
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
                console.log(ukuran_kapasitas);
                if (ukuran_kapasitas) {
                    $.ajax({
                        url: '/standardized_work/Create-Data/Dry-Cast-Resin/kapasitas/' +
                            ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            if (data) {
                                fillSelect('#coil_lv', data, 'COIL LV', 'COIL MAKING');
                                fillSelect('#coil_hv', data, 'COIL HV', 'COIL MAKING');
                                fillSelect('#potong_leadwire', data, 'POTONG LEAD WIRE',
                                    'COIL MAKING');
                                fillSelect('#potong_isolasi', data, 'POTONG ISOLASI',
                                    'COIL MAKING');
                                fillSelect('#hv_moulding', data, 'HV MOULDING',
                                    'MOULD & CASTING');
                                fillSelect('#hv_casting', data, 'HV CASTING',
                                    'MOULD & CASTING');
                                fillSelect('#hv_demoulding', data, 'HV DEMOULDING',
                                    'MOULD & CASTING');
                                fillSelect('#lv_bobbin', data, 'LV BOBBIN',
                                    'MOULD & CASTING');
                                fillSelect('#lv_moulding', data, 'LV MOULDING',
                                    'MOULD & CASTING');
                                fillSelect('#touch_up', data, 'TOUCH UP',
                                    'MOULD & CASTING');
                                fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#wiring', data, 'WIRING', 'CORE COIL ASSEMBLY');
                                fillSelect('#instal_housing', data, 'INSTAL HOUSING',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#bongkar_housing', data, 'BONGKAR HOUSING',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#pembuatan_cu_link', data, 'PEMBUATAN CU LINK',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#others', data, 'OTHERS', 'CORE COIL ASSEMBLY');
                                fillSelect('#accesories', data, 'ACCESORIES',
                                    'CORE COIL ASSEMBLY');
                                fillSelect('#potong_isolasi_fiber', data,
                                    'POTONG ISOLASI FIBER', 'CORE COIL ASSEMBLY');
                                fillSelect('#qc_testing', data, 'ROUNTINE',
                                    'QC TESTv');
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
                                $('#hv_moulding').on('change', function() {
                                    showSelected('hv_moulding');
                                });
                                $('#hv_casting').on('change', function() {
                                    showSelected('hv_casting');
                                });
                                $('#hv_demoulding').on('change', function() {
                                    showSelected('hv_demoulding');
                                });
                                $('#lv_bobbin').on('change', function() {
                                    showSelected('lv_bobbin');
                                });
                                $('#lv_moulding').on('change', function() {
                                    showSelected('lv_moulding');
                                });
                                $('#touch_up').on('change', function() {
                                    showSelected('touch_up');
                                });
                                $('#type_susun_core').on('change', function() {
                                    showSelected('type_susun_core');
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
                            } else {
                                resetForm();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Request Error:', xhr.responseText);
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
            console.log('Select Element:', select);
            let selectedOptions = Array.from(select.selectedOptions);
            let totalDurasi = 0;
            selectedOptions.forEach(function(selectedOption) {
                let selectedDurasi = selectedOption.getAttribute('data-durasi');
                totalDurasi += parseFloat(selectedDurasi || 0);
            });
            let hour = document.getElementById("hour_" + target);
            console.log('Selected Info Element:', hour);
            hour.value = totalDurasi;
            console.log(hour);
            console.log(totalDurasi);
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
            console.log("Work Center (COIL MAKING):", workcenterInfo);
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
            console.log("Work Center (MOULD & CASTING):", workcenterInfo);
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
                    if (workCenterAttr === 'CORE COIL ASSEMBLY') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            console.log("Work Center (CORE COIL ASSEMBLY):", workcenterInfo);
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
                    if (workCenterAttr === 'QC TEST') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            console.log("Work Center (QC TEST):", workcenterInfo);
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
                } else if (workCenter === 'CORE COIL ASSEMBLY') {
                    displayTotalJamCoreCoilAssembly();
                } else if (workCenter === 'QC TEST') {
                    displayTotalJamQCTest();
                }
            });
        });
    </script>

    <script>
        function previewForm() {
            //tampilan hour
            document.getElementById("preview-totalHour_coil_making").innerHTML = document.getElementById(
                    "totalHour_coil_making").innerHTML;
            document.getElementById("preview-hour_coil_lv").innerHTML = document.getElementById(
                "hour_coil_lv").innerHTML;
            document.getElementById("preview-hour_coil_hv").innerHTML = document.getElementById(
                "hour_coil_hv").innerHTML;
            document.getElementById("preview-hour_potong_leadwire").innerHTML = document.getElementById(
                "hour_potong_leadwire").innerHTML;
            document.getElementById("preview-hour_potong_isolasi").innerHTML = document.getElementById(
                "hour_potong_isolasi").innerHTML;
            document.getElementById("preview-hour_hv_moulding").innerHTML = document.getElementById(
                "hour_hv_moulding").innerHTML;
            document.getElementById("preview-hour_hv_casting").innerHTML = document.getElementById(
                "hour_hv_casting").innerHTML;
            document.getElementById("preview-hour_hv_demoulding").innerHTML = document.getElementById(
                "hour_hv_demoulding").innerHTML;
            document.getElementById("preview-hour_lv_bobbin").innerHTML = document.getElementById(
                "hour_lv_bobbin").innerHTML;
            document.getElementById("preview-hour_lv_moulding").innerHTML = document.getElementById(
                "hour_lv_moulding").innerHTML;
            document.getElementById("preview-hour_touch_up").innerHTML = document.getElementById(
                "hour_touch_up").innerHTML;
            document.getElementById("preview-hour_type_susun_core").innerHTML = document.getElementById(
                "hour_type_susun_core").innerHTML;
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
            document.getElementById("preview-totalHour_MouldCasting").innerHTML = document.getElementById(
                "totalHour_MouldCasting").innerHTML;
            document.getElementById("preview-totalHour_CoreCoilAssembly").innerHTML = document.getElementById(
                "totalHour_CoreCoilAssembly").innerHTML;

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
            document.getElementById("preview-so").textContent = document.getElementById("fg").value;
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
