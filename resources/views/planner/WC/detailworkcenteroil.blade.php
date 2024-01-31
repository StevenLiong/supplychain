@extends('planner.template.bar')
@section('content')
@section('workcenteroil', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Detail Work Center Trafo Oil</h4>
            </div>
        </div>
        <div class="card-body">
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
                                    <th style="width: 6rem; text-align: center">Project Name</th>
                                    <th style="width: 6rem; text-align:center">Production Line</th>
                                    <th style="width: 6rem; text-align:center">KVA</th>
                                    <th style="width: 6rem; text-align:center">Quantity</th>
                                    <th style="width: 6rem; text-align:center">Dead Line</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataGpa as $index => $item)
                                @if ($item->jenis === 'Oil Trafo')
                                    <tr role="row" class="odd">
                                        <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                        <td style="width: 6rem; text-align: center">{{ $item->wo->id_wo }}</td>
                                        <td style="width: 6rem; text-align: center">{{ $item->project }}</td>
                                        <td style="width: 6rem; text-align: center">{{ $item->production_line }}</td>
                                        <td style="width: 6rem; text-align: center">{{ $item->kva }}</td>
                                        <td style="width: 6rem; text-align: center">{{ $item->qty_trafo }}</td>
                                        <td style="width: 6rem; text-align: center">{{ \Carbon\Carbon::parse($item->deadline)->format('d-F-Y') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

@endsection