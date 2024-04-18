@extends('produksi.standardized_work.layout')
@section('content')
    <h5 class="text-center my-3 header-title card-title " style="font-size: 40px;color:#d02424;"><b>PERHITUNGAN MAN HOUR</b>
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
    <form class="login-content floating-label " method="post" action="{{ route('store.oil_custom') }}" style="height: auto;">
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
                                <input class="floating-input form-control" type="text" name="nama_product"
                                    value="Oli Custon" id="category" disabled>
                                <label>Category</label>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="kategori" id="kategori"
                                        value="1">
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
                                            ->where('nama_kategoriproduk', 'Oli Custom')
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
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_coil_lv" name="hour_coil_lv"
                                                    value="{{ old('hour_coil_lv') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil LV</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple1" style="width:100%;"
                                                    name="coil_lv[]" id="coil_lv" multiple>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="w-100">
                                        <tr !important>
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_coil_hv" name="hour_coil_hv"
                                                    value="{{ old('hour_coil_hv') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Coil HV</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple1" style="width:100%;"
                                                    name="coil_hv[]" id="coil_hv" multiple>
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
                                            <span class="input-group-text">CORE COIL ASSEMBLY</span>
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
                                                    id="hour_cca" name="hour_cca" value="{{ old('hour_cca') }}"
                                                    readonly>

                                            </td class="w-30">
                                            <td>
                                                <h6 class=" border border-dark rounded p-1 text-center">Core Coil Assembly
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control border border-dark rounded text-center"
                                                    style="height: 33px;" name="cca" id="cca">
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
                                            <span class="input-group-text">CONNECTION</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_Conect" name="totalHour_Conect"
                                                value="{{ old('totalHour_Conect') }}" readonly>
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
                                                    id="hour_connection" name="hour_connection"
                                                    value="{{ old('hour_connection') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Connection
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class=" form-control border border-dark rounded text-center multiple2"
                                                    style="height: 33px;"name="connection[]" id="connection" multiple>

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
                                            <span class="input-group-text">Final ASSEMBLY</span>
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
                                            <td class="w-20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_final_assy" name="hour_final_assy"
                                                    value="{{ old('hour_final_assy') }}" readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Final Assembly</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple3" style="width:100%;"
                                                    name="final_assy[]" id="final_assy" multiple>

                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="w-100">

                                        <tr !important>
                                            <td class="20">
                                                <input class="border border-dark rounded text-center" style="width:100%;"
                                                    id="hour_special_assembly" name="hour_special_assembly"
                                                    value="{{ old('hour_special_assembly') }}" readonly>

                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center ">Special Assembly
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple3" style="width:100%;"
                                                    name="special_assembly[]" id="special_assembly" multiple>

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
                                            <span class="input-group-text">FINISHING</span>
                                        </div>
                                        <div class="input-group-append">
                                            <input type="text" class="input-group-text bg-warning" style="width: 3rem"
                                                id="totalHour_Finishing" name="totalHour_Finishing"
                                                value="{{ old('totalHour_Finishing') }}" readonly>
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
                                                    id="hour_finishing" name="hour_finishing"
                                                    value="{{ old('hour_finishing') }}" readonly>
                                            </td>
                                            <td class="w-30">
                                                <h6 class=" border border-dark rounded p-1 text-center">Finishing</h6>
                                            </td>
                                            <td class="w-50">
                                                <select class=" form-control multiple4" style="width:100%;"
                                                    name="finishing[]" id="finishing" multiple>
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
                                                <h6 class="border border-dark rounded p-1 text-center">Routine Test
                                                </h6>
                                            </td>
                                            <td class="w-50">
                                                <select
                                                    class=" form-control border border-dark rounded text-center multiple5"
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

    </form>
    <script>
        $(document).ready(function() {
            function fillSelect(elementId, data, selectedProses, selectedWorkcenter) {
                var filteredData = data.filter(function(item) {
                    return (
                        item.nama_kategoriproduk === 'Oli Custom' &&
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
                if (ukuran_kapasitas) {
                    $.ajax({
                        url: '/standardized_work/Create-Data/Oil-Custom/kapasitas/' +
                            ukuran_kapasitas,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                fillSelect('#coil_lv', data, 'COIL LV', 'COIL MAKING');
                                fillSelect('#coil_hv', data, 'COIL HV', 'COIL MAKING');
                                fillSelect('#cca', data, 'CORE-COIL ASSEMBLY',
                                    'CORE & COIL ASSEMBLY');
                                fillSelect('#connection', data, 'CONNECTION',
                                    'CONNECTION');
                                fillSelect('#final_assy', data, 'FINAL ASSY',
                                    'FINAL ASSEMBLY');
                                fillSelect('#special_assembly', data,
                                    'SPECIAL ASSEMBLY FOR FINAL ASSY',
                                    'FINAL ASSEMBLY');
                                fillSelect('#finishing', data, 'FINISHING', 'FINISHING');
                                fillSelect('#qc_testing', data, 'QC',
                                    'QC');
                                $('#coil_lv').on('change', function() {
                                    showSelected('coil_lv');
                                });
                                $('#coil_hv').on('change', function() {
                                    showSelected('coil_hv');
                                });
                                $('#cca').on('change', function() {
                                    showSelected('cca');
                                });
                                $('#connection').on('change', function() {
                                    showSelected('connection');
                                });
                                $('#final_assy').on('change', function() {
                                    showSelected('final_assy');
                                });
                                $('#special_assembly').on('change', function() {
                                    showSelected('special_assembly');
                                });
                                $('#finishing').on('change', function() {
                                    showSelected('finishing');
                                });
                                $('#qc_testing').on('change', function() {
                                    showSelected('qc_testing');
                                });
                            } else {
                                resetForm();
                            }
                        },
                        error: function(xhr, status, error) {
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

        function displayTotalJamConnection() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'CONNECTION') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_Conect");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
            }
        }

        function displayTotalJamFinalAssembly() {
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
            let totalJamElement = document.getElementById("totalHour_FinalAssembly");
            if (totalJamElement) {
                totalJamElement.value = totalJam;
            }
        }

        function displayTotalJamFinishing() {
            let selectElements = document.querySelectorAll('select');
            let totalJam = 0;
            let workcenterInfo = {};
            selectElements.forEach(function(select) {
                let selectedOptions = Array.from(select.selectedOptions);
                selectedOptions.forEach(function(selectedOption) {
                    let durasi = parseFloat(selectedOption.getAttribute('data-durasi')) || 0;
                    let workCenterAttr = selectedOption.getAttribute('data-workcenter');
                    if (workCenterAttr === 'FINISHING') {
                        totalJam += durasi;
                        if (!workcenterInfo[workCenterAttr]) {
                            workcenterInfo[workCenterAttr] = durasi;
                        } else {
                            workcenterInfo[workCenterAttr] += durasi;
                        }
                    }
                });
            });
            let totalJamElement = document.getElementById("totalHour_Finishing");
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
                    if (workCenterAttr === 'CORE & COIL ASSEMBLY') {
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
                } else if (workCenter === 'CONNECTION') {
                    displayTotalJamConnection();
                } else if (workCenter === 'FINAL ASSEMBLY') {
                    displayTotalJamFinalAssembly();
                } else if (workCenter === 'CORE & COIL ASSEMBLY') {
                    displayTotalJamCoreCoilAssembly();
                } else if (workCenter === 'FINISHING') {
                    displayTotalJamFinishing();
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
        document.getElementById("submitButton").addEventListener("click", function() {
            document.querySelector("form").submit();
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
            var selectors = [".multiple1", ".multiple2", ".multiple3", ".multiple4", ".multiple5"];
            var displayFunctions = [displayTotalJamCoilMaking,
                displayTotalJamConnection, displayTotalJamFinalAssembly, displayTotalJamFinishing,
                displayTotalJamQCTest
            ];

            // Pengaturan Select2 untuk setiap elemen
            $.each(selectors, function(index, selector) {
                displayTotalJam(selector, displayFunctions[index]);
            });
        });
    </script>


@endsection
