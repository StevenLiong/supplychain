@extends('planner.template.bar')
@section('content')
@section('fg', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    Data Kanban Finish Good
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <form method="POST" action="{{ route('fg.delete') }}">
                    <div class="col text-left">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menghapus semua data finish good?')"><i class="fa-solid fa-trash"></i>Delete All Data</button>
                    </div>
                </form>
                <div class="col text-right">
                    <a href="{{ route('fg-upload-excel') }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Upload Excel Finish Good</a>
                </div>           
            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class="ligth" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 1rem;text-align: center;" rowspan="2" class="text-center align-middle">No</th>
                                <th style="width: 6rem; text-align: center" rowspan="2" class="text-center align-middle">Kode Finish Good</th>
                                <th style="width: 6rem; text-align: center" rowspan="2" class="text-center align-middle">Nama Item</th>
                                <th style="width: 6rem; text-align:center" rowspan="2" class="text-center align-middle">Max Kanban</th>
                                <th style="width: 6rem; text-align:center" rowspan="2" class="text-center align-middle">Stock On Hand</th>
                                <th style="width: 18rem; text-align:center;" colspan="3" class="text-center align-middle">ORDER REQUEST</th>
                            </tr>
                            <tr class="ligth" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">Unit</th>
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">Status</th>
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailFg as $index => $item)
                                <tr role="row" class="odd">
                                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->kode_fg }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->nama_item }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->max_kanban }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->stock_on_hand }}</td>
                                    <td style="width: 6rem; text-align: center;">{{ $item->unit }}</td>
                                    <td style="width: 6rem; text-align: center; background-color: #00ff00;">{{ $item->status }}</td>
                                    <td style="width: 6rem; text-align: center;">{{ $item->realisasi }}</td>
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