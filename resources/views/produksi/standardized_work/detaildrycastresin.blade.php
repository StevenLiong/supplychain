@extends('produksi.standardized_work.layout')
@section('content')
    <div class="text-left mb-2 mt-2">
        <a href="/standardized_work/home" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back
        </a>
    </div>
    <div class="row "  >
        <div class="col-md-12 m-0 ">
            <div class="card rounded m-0" style="border-left-color: red; border-left-width: 10px;">
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col-lg-4">
                            <h6>Category</h6>
                            <p class="p-0 m-0" style="color: #d02424" id="preview-category">
                                <b>{{ $product->nama_product }}</b></p>
                        </div>
                        <div class="col-lg-4">
                            <h6>Kapasitas</h6>
                            <p class="p-0 m-0" style="color: #d02424" id="preview-ukuran_kapasitas">
                                <b>{{ $product->ukuran_kapasitas }}</b></p>
                        </div>
                        <div class="col-lg-4">
                            <h6>SO/No.Proyek</h6>
                            <p class="p-0 m-0" style="color: #d02424" id="preview-so"><b>{{ $product->nomor_so }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-2 mt-0"!important>
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
                                        <span type="text" class="input-group-text bg-warning" style="width: 3rem"
                                            id="preview-totalHour_coil_making">{{ $product->totalHour_coil_making }}</span>
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
                                                id="preview-hour_coil_lv">{{ $product->hour_coil_lv }}
                                            </h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td class="w-30">
                                            <h6 class=" border border-dark rounded p-1 text-center">Coil LV
                                            </h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td class="w-50">
                                            <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_lv">
                                                {{ $product->coil_lv }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_coil_hv">{{ $product->hour_coil_hv }}
                                            </h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center">Coil HV
                                            </h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center" id="preview-coil_hv">
                                                {{ $product->coil_hv }}</h6>

                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                id="preview-hour_potong_leadwire">{{ $product->hour_potong_leadwire }}</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                Lead Wire</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                id="preview-potong_leadwire">{{ $product->potong_leadwire }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_potong_isolasi">{{ $product->hour_potong_isolasi }}</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center">Potong
                                                Isolasi</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                id="preview-potong_isolasi">{{ $product->potong_isolasi }}</h6>
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
                                            id="preview-totalHour_MouldCasting">{{ $product->totalHour_MouldCasting }}
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
                                                id="preview-hour_hv_moulding">{{ $product->hour_hv_moulding }}</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td class="w-30">
                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                Moulding</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td class="w-50">
                                            <h6 class="border bg-warning rounded p-1 text-center" id="preview-hv_moulding">
                                                {{ $product->hv_moulding }}</h6>

                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_hv_casting">{{ $product->hour_hv_casting }}
                                            </h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                Casting</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td class="w-50">
                                            <h6 class="border bg-warning rounded p-1 text-center" id="preview-hv_casting">
                                                {{ $product->hv_casting }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                id="preview-hour_hv_demoulding">{{ $product->hour_hv_demoulding }}</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center">HV
                                                Demoulding</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class="border bg-warning rounded p-1 text-center"
                                                id="preview-hv_demoulding">{{ $product->hv_demoulding }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                id="preview-hour_lv_bobbin">{{ $product->hour_lv_bobbin }}
                                            </h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center">LV
                                                Bobbin</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center" id="preview-lv_bobbin">
                                                {{ $product->lv_bobbin }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                id="preview-hour_lv_moulding">{{ $product->hour_lv_moulding }}
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
                                                id="preview-lv_moulding">{{ $product->lv_moulding }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center"
                                                id="preview-hour_touch_up">{{ $product->hour_touch_up }}
                                            </h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class=" border border-dark rounded p-1 text-center">Touch
                                                Up</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center" id="preview-touch_up">
                                                {{ $product->touch_up }}</h6>
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
                                            id="preview-totalHour_CoreCoilAssembly">{{ $product->totalHour_CoreCoilAssembly }}</span>
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
                                                id="preview-hour_type_susun_core">{{ $product->hour_type_susun_core }}
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
                                                id="preview-type_susun_core">{{ $product->type_susun_core }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_wiring">{{ $product->hour_wiring }}
                                            </h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center">Wiring
                                            </h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center" id="preview-wiring">
                                                {{ $product->wiring }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_instal_housing">{{ $product->hour_instal_housing }}
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
                                                id="preview-instal_housing">{{ $product->instal_housing }}</h6>

                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->

                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_bongkar_housing">{{ $product->hour_bongkar_housing }}
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
                                                id="preview-bongkar_housing">{{ $product->bongkar_housing }}</h6>

                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_pembuatan_cu_link">{{ $product->hour_pembuatan_cu_link }}
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
                                                id="preview-pembuatan_cu_link">{{ $product->pembuatan_cu_link }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_others">{{ $product->hour_others }}</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center">Others
                                            </h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center" id="preview-others">
                                                {{ $product->others }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_accesories">{{ $product->hour_accesories }}</h6>
                                        </td>
                                        <!-- nama proses-->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center">
                                                Accessories</h6>
                                        </td>
                                        <!-- inputan spek -->
                                        <td>
                                            <h6 class=" border bg-warning rounded p-1 text-center"
                                                id="preview-accesories">{{ $product->accesories }}</h6>
                                        </td>
                                    </tr>
                                    <tr !important>
                                        <!-- tampilan hour dari inputan  -->
                                        <td>
                                            <h6 class="border border-dark rounded p-1 text-center"
                                                id="preview-hour_potong_isolasi_fiber">
                                                {{ $product->hour_potong_isolasi_fiber }}
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
                                                id="preview-potong_isolasi_fiber">{{ $product->potong_isolasi_fiber }}
                                            </h6>
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
                                            id="preview-hour_qctesting">{{ $product->totalHour_QCTest }}</span>
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
                                                id="preview-hour_qc_testing">{{ $product->hour_routine_test }}
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
                                                id="preview-qc_testing">{{ $product->routine_test }}</h6>
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

    </div>
@endsection
