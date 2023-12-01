@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-lg-12">
        <div class="row mb-4 align-items-center">
            <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03" data-toggle="dropdown"
                aria-expanded="false">
                <form action="{{ route('process.periode') }}" method="post" id="periodeForm">
                    @csrf
                    <label>Pilih Periode:</label>
                    <select class="custom-select " name="periode" id="periodeSelect"><i
                            class="ri-arrow-down-s-line ml-2 mr-0"></i>
                        <option value="1">Satu Bulan</option>
                        <option value="2">3 minggu</option>
                        <option value="3">2 minggu</option>
                        <option value="4">1 minggu</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            {{-- <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h6>Total MP</h6>
                        </div>
                        <h2><b><span class="counter" style="visibility: visible;">{{ $data['totalManPower'] }}</span>
                            </b> </h2>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h6>Total Hour</h6>
                        </div>
                        <h2><b><span class="counter" style="visibility: visible;">{{ $data['jumlahtotalHourSum'] }}</span>
                            </b> </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h6>Total Kebutuhan MP</h6>
                            <button type="button" class="btn pr-0 mr-0" data-toggle="tooltip" data-placement="top"
                                title=""
                                data-original-title="Jumlah Selisih & Kebutuhan sesuai dengan data real jumlah Man Power">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </div>
                        <h2><b><span class="counter" style="visibility: visible;">{{ $data['kebutuhanMP'] }}</span> </b>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h6>Total Selisih MP</h6>
                            <button type="button" class="btn pr-0 mr-0" data-toggle="tooltip" data-placement="top"
                                title=""
                                data-original-title="Jumlah Selisih & Kebutuhan sesuai dengan data real jumlah Man Power">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </div>
                        <h2><b><span class="counter"
                                    style="visibility: visible;">{{ ($data['selisihKurangMP']) }}</span> </b> </h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h6>Total Ketersediaan MP</h6>
                            <button type="button" class="btn pr-0 mr-0" data-toggle="tooltip" data-placement="top"
                                title=""
                                data-original-title="Ada kelemahan akurasi, yakni kelebihan 1 s.d 2 orang Ketersediaan Man Power karena pembulatan koma">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </div>
                        <h2><b><span class="counter" style="visibility: visible;">{{ $data['ketersediaanMP'] }}</span>
                            </b> </h2>

                        <p style="font-size:10px;text-align: justify; line-height: 1.5;"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>Product Line 2</b></h4>

                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>{{ ($data['qtyPL2']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>{{ ($data['loadkapasitasPL2']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ ($data['jumlahtotalHourSumPL2']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ ($data['kebutuhanMPPL2']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ $data['ketersediaanMPPL2'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>{{ $data['overtimePL2'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <canvas id="chDonutKapasitasPL2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasPL2'] }}%;" aria-valuenow="{{ $data['loadkapasitasPL2'] }}"
                        aria-valuemin="0" aria-valuemax="100">
                        <b>{{ ($data['loadkapasitasPL2']) }}%</b>
                    </div>
                    {{-- <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($data['kapasitasPL2'])-($data['loadkapasitasPL2']) }}%;" aria-valuenow="{{ ($data['kapasitasPL2'])-($data['loadkapasitasPL2']) }}"
                        aria-valuemin="0" aria-valuemax="100"><b>{{ ($data['kapasitasPL2'])-($data['loadkapasitasPL2']) }}%</b></div> --}}
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>Product Line 3</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>{{ $data['qtyPL3'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>{{ ($data['loadkapasitasPL3']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ ($data['jumlahtotalHourSumPL3']) }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ ($data['kebutuhanMPPL3']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ $data['ketersediaanMPPL3'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>{{ $data['overtimePL3'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <canvas id="chDonutKapasitasPL3"></canvas>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasPL3'] }}%;" aria-valuenow="{{ $data['loadkapasitasPL3'] }}"
                        aria-valuemin="0" aria-valuemax="100">
                        <b>{{ $data['loadkapasitasPL3'] }}%</b>
                    </div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>CT / VT</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>{{ $data['qtyCTVT'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>{{ ($data['loadkapasitasCTVT']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ ($data['jumlahtotalHourSumCTVT']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ ($data['kebutuhanMPCTVT']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ $data['ketersediaanMPCTVT'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>{{ $data['overtimeCTVT'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <canvas id="chDonutKapasitasCTVT"></canvas>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasCTVT'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasCTVT'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ $data['loadkapasitasCTVT'] }}%</b>
                    </div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>DRY</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>{{ $data['qtyDRY'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>{{ ($data['loadkapasitasDRY']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ ($data['jumlahtotalHourSumDRY']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ ($data['kebutuhanMPDRY']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ $data['ketersediaanMPDRY'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>{{ $data['overtimeDRY'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <canvas id="chDonutKapasitasDRY"></canvas>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasDRY'] }}%;" aria-valuenow="{{ $data['loadkapasitasDRY'] }}"
                        aria-valuemin="0" aria-valuemax="100">
                        <b>{{ $data['loadkapasitasDRY'] }}%</b>
                    </div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>REPAIR</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>{{ $data['qtyREPAIR'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>{{ ($data['loadkapasitasREPAIR']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ ($data['jumlahtotalHourSumREPAIR']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ ($data['kebutuhanMPREPAIR']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ $data['ketersediaanMPREPAIR'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>{{ $data['overtimeREPAIR'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <canvas id="chDonutKapasitasREPAIR"></canvas>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasREPAIR'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasREPAIR'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ $data['loadkapasitasREPAIR'] }}%</b>
                    </div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    {{-- KAPASITAS PL2 --}}
    <script>
        // chart colors
        var colors = ['#7cc8b8', '#fccc54'];

        /* 3 donut charts */
        var donutOptions = {
            cutoutPercentage: 60,
            legend: {
                position: 'bottom',
                padding: 5,
                labels: {
                    pointStyle: 'circle',
                    usePointStyle: true
                }
            }
        };

        // donut 1
        var chDonutData1 = {
            // labels: ['Capacity', 'Over Capacity'],
            datasets: [{
                backgroundColor: colors.slice(0, 3),
                borderWidth: 2,
                data: [{{ ($data['loadkapasitasPL2']) }}, 0]
            }]
        };

        var chDonutKapasitasPL2 = document.getElementById("chDonutKapasitasPL2");
        if (chDonutKapasitasPL2) {
            new Chart(chDonutKapasitasPL2, {
                type: 'pie',
                data: chDonutData1,
                options: donutOptions
            });
        }
    </script>
    {{-- KAPASITAS PL3 --}}
    <script>
        // chart colors
        var colors = ['#7cc8b8', '#fccc54'];

        /* 3 donut charts */
        var donutOptions = {
            cutoutPercentage: 60,
            legend: {
                position: 'bottom',
                padding: 5,
                labels: {
                    pointStyle: 'circle',
                    usePointStyle: true
                }
            }
        };

        // donut 1
        var chDonutData1 = {
            // labels: ['Capacity', 'Over Capacity'],
            datasets: [{
                backgroundColor: colors.slice(0, 3),
                borderWidth: 2,
                data: [{{ ($data['loadkapasitasPL3']) }}, 0]
            }]
        };

        var chDonutKapasitasPL3 = document.getElementById("chDonutKapasitasPL3");
        if (chDonutKapasitasPL3) {
            new Chart(chDonutKapasitasPL3, {
                type: 'pie',
                data: chDonutData1,
                options: donutOptions
            });
        }
    </script>
    {{-- KAPASITAS CTVT --}}
    <script>
        // chart colors
        var colors = ['#7cc8b8', '#fccc54'];

        /* 3 donut charts */
        var donutOptions = {
            cutoutPercentage: 60,
            legend: {
                position: 'bottom',
                padding: 5,
                labels: {
                    pointStyle: 'circle',
                    usePointStyle: true
                }
            }
        };

        // donut 1
        var chDonutData1 = {
            // labels: ['Capacity', 'Over Capacity'],
            datasets: [{
                backgroundColor: colors.slice(0, 3),
                borderWidth: 2,
                data: [{{ ($data['loadkapasitasCTVT']) }}, 1]
            }]
        };

        var chDonutKapasitasCTVT = document.getElementById("chDonutKapasitasCTVT");
        if (chDonutKapasitasCTVT) {
            new Chart(chDonutKapasitasCTVT, {
                type: 'pie',
                data: chDonutData1,
                options: donutOptions
            });
        }
    </script>
    {{-- KAPASITAS DRY --}}
    <script>
        // chart colors
        var colors = ['#7cc8b8', '#fccc54'];

        /* 3 donut charts */
        var donutOptions = {
            cutoutPercentage: 60,
            legend: {
                position: 'bottom',
                padding: 5,
                labels: {
                    pointStyle: 'circle',
                    usePointStyle: true
                }
            }
        };

        // donut 1
        var chDonutData1 = {
            // labels: ['Capacity', 'Over Capacity'],
            datasets: [{
                backgroundColor: colors.slice(0, 3),
                borderWidth: 2,
                data: [{{ ($data['loadkapasitasDRY']) }}, 2]
            }]
        };

        var chDonutKapasitasDRY = document.getElementById("chDonutKapasitasDRY");
        if (chDonutKapasitasDRY) {
            new Chart(chDonutKapasitasDRY, {
                type: 'pie',
                data: chDonutData1,
                options: donutOptions
            });
        }
    </script>
    {{-- KAPASITAS REPAIR --}}
    <script>
        // chart colors
        var colors = ['#7cc8b8', '#fccc54'];

        /* 3 donut charts */
        var donutOptions = {
            cutoutPercentage: 60,
            legend: {
                position: 'bottom',
                padding: 5,
                labels: {
                    pointStyle: 'circle',
                    usePointStyle: true
                }
            }
        };

        // donut 1
        var chDonutData1 = {
            // labels: ['Capacity', 'Over Capacity'],
            datasets: [{
                backgroundColor: colors.slice(0, 3),
                borderWidth: 2,
                data: [{{ ($data['loadkapasitasREPAIR']) }}, 11]
            }]
        };

        var chDonutKapasitasREPAIR = document.getElementById("chDonutKapasitasREPAIR");
        if (chDonutKapasitasREPAIR) {
            new Chart(chDonutKapasitasREPAIR, {
                type: 'pie',
                data: chDonutData1,
                options: donutOptions
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            // Mendeteksi perubahan pada dropdown
            $('#periodeSelect').change(function() {
                // Mengambil nilai yang dipilih
                var selectedValue = $(this).val();

                // Menyimpan nilai yang dipilih dalam localStorage
                localStorage.setItem('selectedPeriode', selectedValue);

                // Mengirimkan formulir secara otomatis
                $('#periodeForm').submit();
            });

            // Memeriksa apakah ada nilai yang disimpan dalam localStorage
            var storedValue = localStorage.getItem('selectedPeriode');
            if (storedValue) {
                // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
                $('#periodeSelect').val(storedValue);
            }
        });
    </script>
@endsection
