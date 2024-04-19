<div class="col-lg-12 col-sm-6 mt-2">
    <form class="login-content floating-label" method="post"
        action="{{ route('update', $product->dry_cast_resin->kd_manhour) }}">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 text-left input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text font-size-lg"><b>TOTAL HOUR</b></span>
                </div>
                <div class="input-group-append">
                    <input type="text" class="input-group-text font-size-lg bg-warning" id="total_hour"
                        name="total_hour" value="{{ old('total_hour', $product->dry_cast_resin->total_hour) }}"
                        readonly>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                <button type="submit" class="btn btn-primary ">
                    <i class="fa-regular fa-floppy-disk "></i>Update
                </button>
                <a href="/standardized_work/home" class="btn btn-secondary">
                    <i class="fa-solid fa-circle-xmark mr-2"></i>Cancel
                </a>
            </div>
        </div>

        <div class="row px-2 mt-3">
            <div class="col-lg-12">
                <div class="card card-body my-1 pt-3 pb-0">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder=""
                                    name="nama_product" value="{{ $product->dry_cast_resin->nama_product }}"
                                    id="category" readonly>
                                <label>Category</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input type="text" class="floating-input form-control" name="kd_manhour"
                                    id="kd_manhour" value="{{ $product->dry_cast_resin->kd_manhour }}" readonly>
                                <label>Kode Man Hour</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input type="text" class="floating-input form-control" name="ukuran_kapasitas"
                                    id="ukuran_kapasitas" value="{{ $product->dry_cast_resin->ukuran_kapasitas }}"
                                    readonly>
                                <label>Capacity</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="nomor_so"
                                    value="{{ old('nomor_so', $product->dry_cast_resin->nomor_so) }}" id="so"
                                    readonly>
                                <label>SO / No. Prospek</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="floating-label form-group">
                                <input class="floating-input form-control" type="text" placeholder="" name="id_fg"
                                    value="{{ old('id_fg', $product->dry_cast_resin->id_fg) }}" id="fg" readonly>
                                <label>Kode Finish Good</label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <label for="Use Housing or Not">Apakah Menggunakan Housing?</label>
                            <div class="custom-control custom-radio custom-radio-color custom-control-inline">
                                <input type="radio" id="customRadio01" name="housing" class="custom-control-input"
                                    value="Menggunakan Housing"
                                    {{ old('housing', $product->dry_cast_resin->keterangan) == 'Menggunakan Housing' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customRadio01">Ya</label>
                            </div>
                            <div class="custom-control custom-radio custom-radio-color custom-control-inline">
                                <input type="radio" id="customRadio02" name="housing" class="custom-control-input"
                                    value="Tidak Menggunakan Housing"
                                    {{ old('housing', $product->dry_cast_resin->keterangan) == 'Tidak Menggunakan Housing' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customRadio02">Tidak</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row px-2 mt-0"!important>
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
                                            <input type="text" class="input-group-text bg-warning"
                                                style="width: 3rem" id="totalHour_coil_making"
                                                name="totalHour_coil_making"
                                                value="{{ old('totalHour_coil_making', $product->dry_cast_resin->totalHour_coil_making) }}"
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
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_coil_lv" name="hour_coil_lv"
                                                    value="{{ old('hour_coil_lv', $product->dry_cast_resin->hour_coil_lv) }}"
                                                    readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil LV</h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class="form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="coil_lv" id="coil_lv">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_coil_hv" name="hour_coil_hv"
                                                    value="{{ old('hour_coil_hv', $product->dry_cast_resin->hour_coil_hv) }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil HV</h6>
                                            </td>
                                            <td>
                                                <select
                                                    class=" form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="coil_hv" id="coil_hv">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_potong_leadwire"
                                                    name="hour_potong_leadwire"
                                                    value="{{ old('hour_potong_leadwire', $product->dry_cast_resin->hour_potong_leadwire) }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Lead Wire
                                                </h6>
                                            </td>
                                            <td>
                                                <select
                                                    class=" form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="potong_leadwire" id="potong_leadwire">

                                                </select>

                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_potong_isolasi"
                                                    name="hour_potong_isolasi"
                                                    value="{{ old('hour_potong_isolasi', $product->dry_cast_resin->hour_potong_isolasi) }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi
                                                </h6>
                                            </td>
                                            <td>
                                                <select class="form-control  multiple1" name="potong_isolasi[]"
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
                                            <input type="text" class="input-group-text bg-warning"
                                                style="width: 3rem" id="totalHour_MouldCasting"
                                                name="totalHour_MouldCasting"
                                                value="{{ old('totalHour_MouldCasting', $product->dry_cast_resin->totalHour_MouldCasting) }}"
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
                                            <td class="">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_hv_moulding" name="hour_hv_moulding"
                                                    value="{{ old('hour_hv_moulding', $product->dry_cast_resin->hour_hv_moulding) }}"
                                                    readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Moulding
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="hv_moulding" id="hv_moulding">


                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_hv_casting" name="hour_hv_casting"
                                                    value="{{ old('hour_hv_casting', $product->dry_cast_resin->hour_hv_casting) }}"
                                                    readonly>

                                            </td>
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Casting</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="hv_casting" id="hv_casting">


                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_hv_demoulding"
                                                    name="hour_hv_demoulding"
                                                    value="{{ old('hour_hv_demoulding', $product->dry_cast_resin->hour_hv_demoulding) }}"
                                                    readonly>

                                            </td>
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">HV Demoulding
                                                </h6>
                                            </td>
                                            <td>
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="hv_demoulding" id="hv_demoulding">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td class="">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_lv_bobbin" name="hour_lv_bobbin"
                                                    value="{{ old('hour_lv_bobbin', $product->dry_cast_resin->hour_lv_bobbin) }}"
                                                    readonly>

                                            </td>
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">LV Bobbin</h6>
                                            </td>
                                            <td>
                                                <select class=" form-control multiple2" name="lv_bobbin[]"
                                                    id="lv_bobbin" multiple>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_lv_moulding" name="hour_lv_moulding"
                                                    value="{{ old('hour_lv_moulding', $product->dry_cast_resin->hour_lv_moulding) }}"
                                                    readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">LV Moulding
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple2" name="lv_moulding[]"
                                                    id="lv_moulding" multiple>

                                                </select>
                                            </td>
                                        </tr>


                                    </table>
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="20">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_touch_up" name="hour_touch_up"
                                                    value="{{ old('hour_touch_up', $product->dry_cast_resin->hour_touch_up) }}"
                                                    readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Touch Up</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple2" name="touch_up[]"
                                                    id="touch_up" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="20">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_oven" name="hour_oven"
                                                    value="{{ old('hour_oven', $product->dry_cast_resin->hour_oven) }}"
                                                    readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Oven</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple2" name="oven[]" id="oven"
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
                        <div class="card card-body my-1 py-1">
                            <div style="padding: 5px;">
                                <div class="row align-items-center ">
                                    <div class="input-group input-group-md justify-content-center">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">CORE & ASSEMBLY</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning"
                                                style="width: 3rem" id="totalHour_CoreCoilAssembly"
                                                name="totalHour_CoreCoilAssembly"
                                                value="{{ old('totalHour_CoreCoilAssembly', $product->dry_cast_resin->totalHour_CoreCoilAssembly) }}"
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
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_type_susun_core"
                                                    name="hour_type_susun_core"
                                                    value="{{ old('hour_type_susun_core', $product->dry_cast_resin->hour_type_susun_core) }}"
                                                    readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Type Susun Core
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class=" form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="type_susun_core" id="type_susun_core">


                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_wiring" name="hour_wiring"
                                                    value="{{ old('hour_wiring', $product->dry_cast_resin->hour_wiring) }}"
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
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_instal_housing"
                                                    name="hour_instal_housing"
                                                    value="{{ old('hour_instal_housing', $product->dry_cast_resin->hour_instal_housing) }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Instal Housing
                                                </h6>
                                            </td>
                                            <td>
                                                <select
                                                    class=" form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="instal_housing" id="instal_housing">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_bongkar_housing"
                                                    name="hour_bongkar_housing"
                                                    value="{{ old('hour_bongkar_housing', $product->dry_cast_resin->hour_bongkar_housing) }}"
                                                    readonly>


                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Bongkar Housing
                                                </h6>
                                            </td>
                                            <td>
                                                <select
                                                    class=" form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="bongkar_housing" id="bongkar_housing">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_pembuatan_cu_link"
                                                    name="hour_pembuatan_cu_link"
                                                    value="{{ old('hour_pembuatan_cu_link', $product->dry_cast_resin->hour_pembuatan_cu_link) }}"
                                                    readonly>

                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Pembuatan CU
                                                    Link
                                                </h6>
                                            </td>
                                            <td>
                                                <select
                                                    class=" form-control border border-dark rounded text-center"style="height: 33px;"
                                                    name="pembuatan_cu_link" id="pembuatan_cu_link">

                                                </select>
                                            </td>
                                        </tr>
                                        <tr !important>
                                            <td>
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_others" name="hour_others"
                                                    value="{{ old('hour_others', $product->dry_cast_resin->hour_others) }}"
                                                    readonly>

                                            </td>
                                            <td>
                                                <h6 class="border border-dark rounded p-1 text-center">Others</h6>
                                            </td>
                                            <td style="width:500px ">
                                                <select class=" form-control multiple3" name="others[]"
                                                    id="others" multiple>

                                                </select>
                                            </td>
                                        </tr>

                                    </table>
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_accesories" name="hour_accesories"
                                                    value="{{ old('hour_accesories', $product->dry_cast_resin->hour_accesories) }}"
                                                    readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Accessories</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple3" name="accesories[]"
                                                    id="accesories" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_potong_isolasi_fiber"
                                                    name="hour_potong_isolasi_fiber"
                                                    value="{{ old('hour_potong_isolasi_fiber', $product->dry_cast_resin->hour_potong_isolasi_fiber) }}"
                                                    readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">Potong Isolasi
                                                    Fiber
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple3" name="potong_isolasi_fiber[]"
                                                    id="potong_isolasi_fiber" multiple>
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
                                            <input type="text" class="input-group-text bg-warning"
                                                style="width: 3rem" id="totalHour_QCTest" name="totalHour_QCTest"
                                                value="{{ old('totalHour_QCTest', $product->dry_cast_resin->totalHour_QCTest) }}"
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
                                                <input class="border border-dark rounded text-center"
                                                    style="width:100%;" id="hour_qc_testing" name="hour_qc_testing"
                                                    value="{{ old('hour_qc_testing', $product->dry_cast_resin->hour_qc_testing) }}"
                                                    readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class="border border-dark rounded p-1 text-center">QC Test
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control  multiple4" name="qc_testing[]"
                                                    id="qc_testing" multiple>
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
</div>
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'Dry Resin' &&
                        item.nama_workcenter === selectedWorkcenter &&
                        item.nama_proses === selectedProses
                    );
                });
                $(elementId).empty();
                $(elementId).append('<option value="">-Pilih-</option>');
                // var previousValue = ;
                $.each(filteredData, function(key, data) {
                    var option = $('<option value="' + data.nama_tipeproses + '" data-durasi="' + data
                        .durasi_manhour + '" data-workcenter="' + data.nama_workcenter + '">' + data
                        .nama_tipeproses + '</option>');

                    $(elementId).append(option);
                });
            }
            // var value = {
            //     coil_lv: '{{ $product->dry_cast_resin->coil_lv }}',
            //     coil_hv: '{{ $product->dry_cast_resin->coil_hv }}',
            //     potong_isolasi: '{{ $product->dry_cast_resin->potong_isolasi }}',
            //     potong_leadwire: '{{ $product->dry_cast_resin->potong_leadwire }}',
            //     lv_moulding: '{{ $product->dry_cast_resin->lv_moulding }}'
            // };

            // console.log(value);

            $(document).ready(function() {
                // Memanggil loadData() saat dokumen siap
                loadData();

                // Ketika nilai input teks readonly berubah
                $('#ukuran_kapasitas_readonly').on('change', function() {
                    // Perbarui nilai select
                    var selectedValue = $(this).val();
                    $('#ukuran_kapasitas').val(selectedValue);
                });

                // Ketika select berubah
                $('#ukuran_kapasitas').on('change', function() {
                    // Panggil loadData() saat perubahan terjadi pada select
                    loadData();
                });
            });


            function loadData() {
                var ukuran_kapasitas = $('#ukuran_kapasitas').val();
                if (ukuran_kapasitas) {
                    $.ajax({
                        url: '/standardized_work/Create-Data/Dry-Cast-Resin/kapasitas/' + ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
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
                                fillSelect('#oven', data, 'OVEN',
                                    'MOULD & CASTING');
                                fillSelect('#type_susun_core', data, 'TYPE SUSUN CORE',
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
                                $('#oven').on('change', function() {
                                    showSelected('oven');
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
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error if needed
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
{{-- </div> --}}
