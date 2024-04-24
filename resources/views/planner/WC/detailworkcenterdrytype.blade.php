@extends('planner.template.bar')
@section('content')
@section('workcenterdrytype', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Detail Work Center Dry Type</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col text-left">
                    <a href="{{ route('wc.exportPDFdry', $dataWorkcenter->nama_workcenter) }}" class="btn btn-primary"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                </div>          
            </div>
            <form>
                <div class="form-row">
                    <div class="col-md-4 mb-2">
                        <label for="workcenter">Work Center</label>
                        <input type="text" class="form-control" name="nama_workcenter" value="{{ $dataWorkcenter->nama_workcenter }}"required disabled>
                    </div>
                </div>    
            </form>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                    <th style="width: 1rem;text-align: center;">No</th>
                                    <th style="width: 6rem; text-align: center">Work Order Code</th>
                                    <th style="width: 6rem; text-align:center">Start Date</th>
                                    <th style="width: 6rem; text-align:center">Dead Line</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deadlines as $index => $deadline)
                                <tr role="row" class="odd">
                                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $deadline['id_wo'] }}</td>
                                    {{-- <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->project }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->production_line }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->kva }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $dataWorkcenter->qty_trafo }}</td>
                                    <td style="width: 6rem; text-align: center">{{ \Carbon\Carbon::parse($dataWorkcenter->start)->format('d-F-Y') }}</td> --}}
                                    <td style="width: 6rem; text-align: center">{{ $deadline['startWc'] }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $deadline['deadlineWc'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

@endsection