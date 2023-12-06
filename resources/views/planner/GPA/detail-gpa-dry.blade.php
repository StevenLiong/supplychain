@extends('planner.template.bar')
@section('content')
@section('gpadry', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Detail GPA Trafo Dry Type</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col  text-left">
                    <a href="{{ route('gpa.exportPdfDetail', $dataMps->id_wo) }}" class="btn btn-primary"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
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
                            $mpsDryType = $dataMps->firstWhere('jenis', 'Dry Type');
                        @endphp
                        @if($mpsDryType)
                            <input type="text" class="form-control" name="deadline" value="{{ \Carbon\Carbon::parse($mpsDryType->deadline)->format('d-F-Y') }}" required disabled>
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
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection