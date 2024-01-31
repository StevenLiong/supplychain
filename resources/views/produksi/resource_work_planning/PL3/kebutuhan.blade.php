@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Jumlah Man Power dan Mesin</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center">
                    <form action="{{ route('process.workcenter') }}" method="post" class="ml-2" id="workcenterForm">
                        @csrf
                        <select class="custom-select" name="selectedWorkcenter" id="workcenterSelect"><i
                                class="ri-arrow-down-s-line ml-2 mr-0">Hour/Day</i>
                            <option value="1">8 Hours/1 Day</option>
                            <option value="2">16 Hours/2 Day</option>
                            <option value="3">24 Hours/3 Day</option>
                        </select>
                    </form>
                    <form action="{{ route('process.workcenter') }}" method="post" class="ml-2" id="workcenterForm">
                        @csrf
                        <select class="custom-select" name="selectedWorkcenter" id="workcenterSelect"><i
                                class="ri-arrow-down-s-line ml-2 mr-0">shift</i>
                            <option value="1">Shift 1</option>
                            <option value="2">Shift 2</option>
                            <option value="3">Shift 3</option>
                        </select>
                    </form>
                    {{-- <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03"
                        data-toggle="dropdown" aria-expanded="false">
                        <div class="btn btn-primary">Work Center<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> Coil Making</a>
                            <a class="dropdown-item" href="#"> CCA</a>
                            <a class="dropdown-item" href="#"> Connect</a>
                            <a class="dropdown-item" href="#"> Final Assy</a>
                            <a class="dropdown-item" href="#"> Special Assembly For Final Assy</a>
                            <a class="dropdown-item" href="#"> Finishing</a>
                            <a class="dropdown-item" href="#"> QC Testing</a>
                        </div>
                    </div> --}}
                    {{-- <div class="ml-auto mr-3" style="align-items: d-flex right;">
                        <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i
                                class="mr-2 fa-solid fa-print"></i>Print</a>
                    </div> --}}
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="text-center">
                                <tr>
                                    <th>Work Center</th>
                                    <th>Total MH</th>
                                    <th>Total Kebutuhan MP</th>
                                    <th>Ketersediaan MP</th>
                                    <th>Kekurangan MP</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td>
                                        {{-- {{ $data['wc_Coil_Making_LV'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{$data['jumlahtotalHourCoil_Making_LV']}} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['kebutuhanMPCoil_Making_LV'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['ketersediaanMPCoil_Making_LV'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['selisihMPCoil_Making_LV'] }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{-- {{ $data['wc_Coil_Making_HV'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{$data['jumlahtotalHourCoil_Making_HV']}} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['kebutuhanMPCoil_Making_HV'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['ketersediaanMPCoil_Making_HV'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['selisihMPCoil_Making_HV'] }} --}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        {{-- {{ $data['wc_Mould_Casting'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{$data['jumlahtotalHourMould_Casting']}} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['kebutuhanMPMould_Casting'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['ketersediaanMPMould_Casting'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['selisihMPMould_Casting'] }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {{-- {{ $data['wc_Core_Assembly'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{$data['jumlahtotalHourCore_Assembly']}} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['kebutuhanMPCore_Assembly'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['ketersediaanMPCore_Assembly'] }} --}}
                                    </td>
                                    <td>
                                        {{-- {{ $data['selisihMPCore_Assembly'] }} --}}
                                    </td>
                                </tr>

                            </tbody>
                            {{-- <tfoot class="text-center">
                                <tr>
                                    <th>Total</th>
                                    <th>20</th>
                                    <th>15</th>
                                    <th>20</th>
                                    <th>15</th>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <th>-3</th>
                                    <th>1</th>
                                    <th>-1</th>
                                    <th>-2</th>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
