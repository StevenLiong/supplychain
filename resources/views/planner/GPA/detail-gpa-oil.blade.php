@extends('planner.template.bar')
@section('content')
@section('gpaoil', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Detail GPA Trafo Oil</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col  text-left">
                    <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                    <a href="#" class="MR-3 btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa fa-table"></i>Download Exel</a>
                </div>
            </div>
            <form>
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label for="id_wo">Work Order</label>
                        <input type="text" class="form-control" name="id_wo" value="{{ $dataMps->id_wo }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="production_line">Production Line</label>
                        <input type="text" class="form-control" name="production_line" value="{{ $dataMps->production_line }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="kva">KVA</label>
                        <input type="text" class="form-control" name="kva" value="{{ $dataMps->kva }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="qty_trafo">Quantity</label>
                        <input type="text" class="form-control" name="qty_trafo" value="{{ $dataMps->qty_trafo }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="lead_time">Lead Time</label>
                        <input type="text" class="form-control" name="lead_time" value="{{ $dataMps->lead_time }}"required disabled>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="validationDefault07">Dead Line</label>
                        {{-- @php
                            $mpsOilTrafo = $dataMps->where('jenis', 'Oil Trafo')->first();
                            $latestDeadline = $dataMps->where('jenis', 'Oil Trafo')->latest('created_at')->first()->deadline ?? null;
                        @endphp
                        @if($latestDeadline)
                            <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($latestDeadline)->format('d-F-Y') }}" required disabled>
                        @endif --}}
                        <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($dataMps->deadline)->format('d-F-Y') }}"required disabled>
                    </div>
                </div>    
            </form>
            <div class="table-responsive" style="margin-top: 1rem">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table table-striped dataTable">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <th style="width: 15rem;text-align: center;">Work Center</th>
                                <th style="width: 15rem;text-align:center">Dead Line</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 1)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(8)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 2)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(7)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 3)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(6)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 4)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(5)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 5)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(4)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 6)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(3)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 7)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(2)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 8)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 9)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 10)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 11)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 12)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 13)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 14)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 15)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">{{ $dataWorkcenter->where('id', 16)->first()->nama_workcenter }}</td>
                                <td style="text-align: center">{{ \Carbon\Carbon::parse($dataMps->deadline)->subDays(1)->format('d-F-Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection