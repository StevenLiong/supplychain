@extends('planner.template.bar')
@section('content')
{{-- @section('mps', 'active')
@section('main', 'show') --}}
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    Global Picking Area - Dry Type
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col text-left">
                    <a href="{{ route('mps.exportPdf') }}" class="btn btn-primary"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                    <a href="{{ route('mps.exportExcel') }}" class="btn btn-primary"><i class="mr-2 fa-regular fa-file-excel"></i>Download Excel</a>
                </div>          
            </div>
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
                                    <th style="width: 6rem; text-align:center">Jenis Trafo</th>
                                    <th style="width: 6rem; text-align:center">Quantity</th>
                                    <th style="width: 6rem; text-align:center">Lead Time (Hari)</th>
                                    <th style="width: 6rem; text-align:center">Dead Line</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataMps as $index => $item)
                                <tr role="row" class="odd">
                                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                    <td style="width: 6rem; text-align: center"><a href="{{ route('gpa.detail-gpa-dry') }}"></a>{{ $item->id_wo }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->project }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->production_line }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->kva }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->jenis }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->qty_trafo }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->lead_time }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->deadline }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection