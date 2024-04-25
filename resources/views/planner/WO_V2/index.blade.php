@extends('planner.template.bar')
@section('content')
@section('work-order-v2', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    Work Order V2
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col text-left">
                    <!-- <a href="{{ route('wo_v2.exportPdf') }}" class="btn btn-primary"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a> -->
                    <!-- <a href="{{ route('wo_v2.exportExcel') }}" class="MR-3 btn btn-primary"><i class="mr-2 fa fa-table"></i>Download Exel</a> -->
                </div>
                <div class="col  text-right">
                    <a href="{{ route('wo_v2-upload-excel') }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Upload WO</a>
                </div>           
            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                    <th style="width: 6rem; text-align:center">Action</th>
                                    <th style="width: 1rem;text-align: center;">No</th>
                                    <th style="width: 6rem; text-align: center">Work Order Code</th>
                                    <th style="width: 6rem; text-align: center">BOM Code</th>
                                    <th style="width: 6rem; text-align:center">ID Finish Good</th>
                                    <th style="width: 3rem; text-align:center">Quantity</th>
                                    <th style="width: 6rem; text-align:center">Start Date</th>
                                    <th style="width: 6rem; text-align:center">Finish Date</th>
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataWo as $index => $item)
                                <tr role="row" class="odd">
                                    <td style="text-align: center; width: 1rem">
                                        <form method="POST" action="{{ route('wo_v2.delete', ['id' => $item->id])}}">
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menghapus ID WO tersebut?')"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->id_wo }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->id_boms }}</td>
                                    <td style="width: 6rem; text-align: center">{{ $item->id_fg }}</td>
                                    <td style="width: 3rem; text-align: center">{{ $item->qty_trafo }}</td>
                                    <td style="width: 6rem; text-align: center">{{ \Carbon\Carbon::parse($item->start_date)->format('d-F-Y') }}</td>
                                    <td style="width: 6rem; text-align: center">{{ \Carbon\Carbon::parse($item->finish_date)->format('d-F-Y') }}</td>
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