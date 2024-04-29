@extends('planner.template.bar')
@section('content')
@section('bill-of-material-v2', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Bill Of Material V2</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col  text-right">
                    <a href="{{ route('bom_v2-upload-excel') }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Upload BOM</a>
                </div>               
            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                            <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 4rem;text-align: center;">Action</th>
                                <th style="width: 4rem;text-align: center;">No</th>
                                <th style="width: 15rem; text-align: center">BOM Code</th>
                                <th style="width: 15rem;text-align: center;">Sales Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataBom as $key => $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    <form method="POST" action="{{ route('bom_v2.delete', ['id_bom' => $item->id_bom]) }}">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a href="{{ route('bom_v2.detailbom', $item->id_bom) }}" class="btn btn-primary"><i class="fa-solid fa-info"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menghapus ID BOM tersebut?')"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </form>
                                </td>
                                <td style="text-align: center;" class="sorting_1">{{ $key + 1 }}</td>
                                <td style="text-align: center">{{$item->id_bom}}</td>
                                <td style="text-align: center">{{ $item->id_so }}</td>
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