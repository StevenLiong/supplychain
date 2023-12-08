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
                        <option value="1">Bulan Sekarang</option>
                        <option value="2">Minggu sekarang</option>
                        <option value="3">Minggu Depan</option>
                        <option value="4">2 Minggu kedepan</option>
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
                            <button type="button" class="btn pr-0 mr-0" data-toggle="tooltip" data-placem,2ent="top"
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
                        <h2><b><span class="counter" style="visibility: visible;">{{ $data['selisihKurangMP'] }}</span>
                            </b> </h2>
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
                        <h2><b><span class="counter" style="visibility: visible;">{{ $data['totalManPower'] }}</span>
                            </b> </h2>

                        <p style="font-size:10px;text-align: justify; line-height: 1.5;"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="header-title mb-5">
                    <div class="row mt-2 mb-0">
                        <div class="col">
                            <h4 class="card-title"><b>Production Line 2</b></h4>
                        </div>
                        <div class="col">
                            <div class="text-right mr-1">
                                @if ($data['ifoverCapacityPL2'])
                                    <span class="mt-2 badge badge-primary">Over Capacity</span>
                                @else
                                    <span class="mt-2 badge badge-success">Under Capacity</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>{{ $data['qtyPL2'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>{{ round($data['loadkapasitasPL2'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ $data['jumlahtotalHourSumPL2'] }}</h3>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ round($data['kebutuhanMPPL2']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ round($data['ketersediaanMPPL2']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime (%)</h6>
                                <h3>{{ round($data['overtimePL2'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            @if ($data['qtyPL2'] == 0)
                                <div class="card-body text-center">
                                    <h6>Chart Data</h6>
                                    <p style=" text-align: center; vrtical-align: middle;">No Data</p>
                                </div>
                            @else
                                <canvas id="chDonutKapasitasPL2"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    {{-- bar ijo untuk data kapasitas --}}
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasPL2new'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasPL2new'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ round($data['loadkapasitasPL2new'], 2) }}%</b>
                    </div>
                    {{-- bar merah data over --}}
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: {{ $data['overCapacityPL2'] }}%;" aria-valuenow="{{ $data['overCapacityPL2'] }}"
                        aria-valuemin="0" aria-valuemax="{{ $data['overCapacityPL2'] }}">
                        <b>{{ round($data['overCapacityPL2'], 2) }}%</b>
                    </div>
                </div>
                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-success mr-1" style="height: 15px"> </span> Under Capacity
                    <span class="badge badge-primary mr-1 ml-5" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="header-title mb-5">
                    <div class="row mt-2 mb-0">
                        <div class="col">
                            <h4 class="card-title"><b>Production Line 3</b></h4>
                        </div>
                        <div class="col">
                            <div class="text-right mr-1">
                                @if ($data['ifoverCapacityPL3'])
                                    <span class="mt-2 badge badge-primary">Over Capacity</span>
                                @else
                                    <span class="mt-2 badge badge-success">Under Capacity</span>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                <h3>{{ round($data['loadkapasitasPL3'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ $data['jumlahtotalHourSumPL3'] }}</h3>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ round($data['kebutuhanMPPL3']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ round($data['ketersediaanMPPL3']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime (%)</h6>
                                <h3>{{ round($data['overtimePL3'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            @if ($data['qtyPL3'] == 0)
                            <div class="card-body text-center">
                                <h6>Chart Data</h6>
                                <p style=" text-align: center; vrtical-align: middle;">No Data</p>
                            </div>
                        @else
                            <canvas id="chDonutKapasitasPL3"></canvas>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    {{-- bar ijo untuk data kapasitas --}}
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasPL3new'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasPL3new'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ round($data['loadkapasitasPL3new'], 2) }}%</b>
                    </div>
                    {{-- bar merah data over --}}
                    <div class="progress-bar bg-warning" role="progressbar"
                        style="width: {{ $data['overCapacityPL3'] }}%;" aria-valuenow="{{ $data['overCapacityPL3'] }}"
                        aria-valuemin="0" aria-valuemax="{{ $data['overCapacityPL3'] }}">
                        <b>{{ round($data['overCapacityPL3'], 2) }}%</b>
                    </div>
                </div>
                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-success mr-1" style="height: 15px"> </span> Under Capacity
                    <span class="badge badge-primary mr-1 ml-5" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title mb-5">
                    <div class="row mt-2 mb-0">
                        <div class="col">
                            <h4 class="card-title"><b>CT / VT</b></h4>
                        </div>
                        <div class="col">
                            <div class="text-right mr-1">
                                @if ($data['ifoverCapacityCTVT'])
                                    <span class="mt-2 badge badge-primary">Over Capacity</span>
                                @else
                                    <span class="mt-2 badge badge-success">Under Capacity</span>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                <h3>{{ round($data['loadkapasitasCTVT'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ $data['jumlahtotalHourSumCTVT'] }}</h3>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ round($data['kebutuhanMPCTVT']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ round($data['ketersediaanMPCTVT']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime (%)</h6>
                                <h3>{{ round($data['overtimeCTVT'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            @if ($data['qtyCTVT'] == 0)
                                <div class="card-body text-center">
                                    <h6>Chart Data</h6>
                                    <p style=" text-align: center; vrtical-align: middle;">No Data</p>
                                </div>
                            @else
                                <canvas id="chDonutKapasitasCTVT"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    {{-- bar ijo untuk data kapasitas --}}
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasCTVTnew'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasCTVTnew'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ round($data['loadkapasitasCTVTnew'], 2) }}%</b>
                    </div>
                    {{-- bar merah data over --}}
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: {{ $data['overCapacityCTVT'] }}%;" aria-valuenow="{{ $data['overCapacityCTVT'] }}"
                        aria-valuemin="0" aria-valuemax="{{ $data['overCapacityCTVT'] }}">
                        <b>{{ round($data['overCapacityCTVT'], 2) }}%</b>
                    </div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-success mr-1" style="height: 15px"> </span> Under Capacity
                    <span class="badge badge-primary mr-1 ml-5" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title mb-5">
                    <div class="row mt-2 mb-0">
                        <div class="col">
                            <h4 class="card-title"><b>Dry</b></h4>
                        </div>
                        <div class="col">
                            <div class="text-right mr-1">
                                @if ($data['ifoverCapacityDRY'])
                                    <span class="mt-2 badge badge-primary">Over Capacity</span>
                                @else
                                    <span class="mt-2 badge badge-success">Under Capacity</span>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                <h3>{{ round($data['loadkapasitasDRY'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ $data['jumlahtotalHourSumDRY'] }}</h3>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ round($data['kebutuhanMPDRY']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ round($data['ketersediaanMPDRY']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime (%)</h6>
                                <h3>{{ round($data['overtimeDRY'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            @if ($data['qtyDRY'] == 0)
                                <div class="card-body text-center">
                                    <h6>Chart Data</h6>
                                    <p style=" text-align: center; vrtical-align: middle;">No Data</p>
                                </div>
                            @else
                                <canvas id="chDonutKapasitasDRY"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    {{-- bar ijo untuk data kapasitas --}}
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasDRYnew'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasDRYnew'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ round($data['loadkapasitasDRYnew'], 2) }}%</b>
                    </div>
                    {{-- bar merah data over --}}
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: {{ $data['overCapacityDRY'] }}%;" aria-valuenow="{{ $data['overCapacityDRY'] }}"
                        aria-valuemin="0" aria-valuemax="{{ $data['overCapacityDRY'] }}">
                        <b>{{ round($data['overCapacityDRY'], 2) }}%</b>
                    </div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-success mr-1" style="height: 15px"> </span> Under Capacity
                    <span class="badge badge-primary mr-1 ml-5" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title mb-5">
                    <div class="row mt-2 mb-0">
                        <div class="col">
                            <h4 class="card-title"><b>Repair</b></h4>
                        </div>
                        <div class="col">
                            <div class="text-right mr-1">
                                @if ($data['ifoverCapacityREPAIR'])
                                    <span class="mt-2 badge badge-primary">Over Capacity</span>
                                @else
                                    <span class="mt-2 badge badge-success">Under Capacity</span>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                <h3>{{ round($data['loadkapasitasREPAIR'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Total Man Hour</h6>
                                <h3>{{ $data['jumlahtotalHourSumREPAIR'] }}</h3>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>{{ round($data['kebutuhanMPREPAIR']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Ketersediaan MP</h6>
                                <h3>{{ round($data['ketersediaanMPREPAIR']) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime (%)</h6>
                                <h3>{{ round($data['overtimeREPAIR'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            @if ($data['qtyREPAIR'] == 0)
                                <div class="card-body text-center">
                                    <h6>Chart Data</h6>
                                    <p style=" text-align: center; vrtical-align: middle;">No Data</p>
                                </div>
                            @else
                                <canvas id="chDonutKapasitasREPAIR"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    {{-- bar ijo untuk data kapasitas --}}
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $data['loadkapasitasREPAIRnew'] }}%;"
                        aria-valuenow="{{ $data['loadkapasitasREPAIRnew'] }}" aria-valuemin="0" aria-valuemax="100">
                        <b>{{ round($data['loadkapasitasREPAIRnew'], 2) }}%</b>
                    </div>
                    {{-- bar merah data over --}}
                    <div class="progress-bar bg-primary" role="progressbar"
                        style="width: {{ $data['overCapacityREPAIR'] }}%;"
                        aria-valuenow="{{ $data['overCapacityREPAIR'] }}" aria-valuemin="0"
                        aria-valuemax="{{ $data['overCapacityREPAIR'] }}">
                        <b>{{ round($data['overCapacityREPAIR'], 2) }}%</b>
                    </div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-success mr-1" style="height: 15px"> </span> Under Capacity
                    <span class="badge badge-primary mr-1 ml-5" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    {{-- KAPASITAS PL2 --}}
    <script>
        // chart colors
        var colors = ['#7cc8b8', '#d02424'];

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
                data: [{{ round($data['loadkapasitasPL2new'],2) }} , {{ round($data['overCapacityPL2'], 2) }}]
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
        var colors = ['#7cc8b8', '#d02424'];

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
                data: [{{ round($data['loadkapasitasPL3new'],2) }}, {{ round($data['overCapacityPL3'], 2) }}]
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
        var colors = ['#7cc8b8', '#d02424'];

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
                data: [{{ round($data['loadkapasitasCTVTnew'],2) }}, {{ round($data['overCapacityCTVT'], 2) }}]
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
        var colors = ['#7cc8b8', '#d02424'];

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
                data: [{{ round($data['loadkapasitasDRYnew'],2) }}, {{ round($data['overCapacityDRY'], 2) }}]
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
        var colors = ['#7cc8b8', '#d02424'];

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
                data: [{{ round($data['loadkapasitasREPAIRnew'],2) }}, {{ round($data['overCapacityREPAIR'], 2) }}]
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
