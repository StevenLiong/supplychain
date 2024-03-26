@extends('planner.template.bar')
@section('content')
@section('material', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    Upload Data Material
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <form method="POST" action="{{ route('material.delete') }}">
                    <div class="col text-left">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menghapus semua data material?')"><i class="fa-solid fa-trash"></i>Delete All Data</button>
                    </div>
                </form>
                <div class="col text-right">
                    <a href="{{ route('material-upload-excel') }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Upload Excel Material</a>
                </div>           
            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                    <th style="width: 1rem;text-align: center;">No</th>
                                    <th style="width: 6rem; text-align: center">Item Code</th>
                                    <th style="width: 6rem; text-align: center">Item Name</th>
                                    <th style="width: 6rem; text-align:center">Unit</th>
                                    <th style="width: 6rem; text-align:center">Quantity</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailMaterial as $index => $item)
                                <tr role="row" class="odd">
                                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->kd_material }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->nama_material }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->satuan }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->jumlah }}</td>
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