@extends('planner.template.bar')
@section('content')
@section('bill-of-material', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Bill Of Material</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <!-- <div class="col  text-left">
                    <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                    <a href="#" class="MR-3 btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa fa-table"></i>Download Exel</a>
                </div> -->

                <div class="col  text-right">
                    <a href="{{ route('bom-create') }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Create BOM</a>
                </div>               

            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                            <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th>Action</th>
                                <th style="width: 4rem;text-align: center;">No</th>
                                <th style="width: 15rem; text-align: center">BOM Code</th>
                                <th>BOM Status</th>
                                <th style="width: 6rem;">Quantity</th>
                                <th>UOM BOM</th>
                                <th style="width: 6rem;">Status</th>
                                <th>Keterangan</th>
                                <th>Sales Order</th>
                                <th>Kode Finish Good</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataBom as $key => $item)
                            <tr role="row" class="odd">
                                <!-- @php
                                    $deleteBom = $detailBom->where('id_boms', $item->id_bom)->first();
                                @endphp -->
                                <td style="text-align: center;">
                                    <form method="POST" action="{{ route('bom.delete', ['id_bom' => $item->id_bom]) }}">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a href="{{ route('bom.detailbom', $item->id_bom) }}" class="btn btn-primary"><i class="fa-solid fa-info"></i></a>
                                            <a href="{{ route('bom.editbom', $item->id_bom) }}" class="btn btn-primary"><i class="fa-solid fa-edit"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menghapus ID BOM tersebut?')"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                    </form>
                                </td>
                                <td style="text-align: center;" class="sorting_1">{{ $key + 1 }}</td>
                                <td style="text-align: center">{{$item->id_bom}}</td>
                                <td style="text-align: center">{{$item->bom_status}}</td>
                                <td style="text-align: center;">{{$item->qty_bom}}</td>
                                <td style="text-align: center">{{$item->uom_bom}}</td>
                                @if ($item->status_bom == 3)
                                        <td>
                                            <span class="btn btn-success btn-sm text-uppercase">Approved</span>
                                        </td>
                                    @elseif($item->status_bom == 2)
                                    <td>
                                        <span class="btn btn-warning btn-sm text-uppercase">Completed</span>
                                    </td>
                                    @elseif($item->status_bom == 1)
                                        <td>
                                            <span class="btn btn-warning btn-sm text-uppercase">Pending</span>
                                        </td>
                                    @elseif($item->status_bom == 0)
                                    <td>
                                        <span class="btn btn-warning btn-sm text-uppercase">Process</span>
                                    </td>
                                @endif
                                @if ($item->status_bom == 3)
                                        <td>
                                            BOM ini sudah terbit
                                        </td>   
                                    @elseif ($item->status_bom == 2)
                                    <td>
                                        Silahkan Submit Material
                                    </td>
                                    @elseif ($item->status_bom == 1)
                                        <td>
                                            Terdapat Material Kurang
                                        </td>
                                    @elseif ($item->status_bom == 0)
                                        <td>
                                            Pengecekan Material
                                        </td>
                                @endif
                                <td style="text-align: center">{{ $item->id_so }}</td>
                                <td style="text-align: center;">{{$item->id_fg}}</td>
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