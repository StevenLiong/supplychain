@extends('planner.template.bar')
  @section('content')
  @section('bill-of-material-v2', 'active')
@section('main', 'show')
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <div class="header-title">
        <h4 class="card-title">Detail Bill Of Material V2</h4>
      </div>
    </div>
    <div class="card-body">
      <form>
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="validationDefault01">BOM Code</label>
            <input type="text" class="form-control" name="id_bom" value="{{ $dataBom->id_bom }}" required disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault03">Sales Order</label>
            <input type="text" class="form-control" name="id_so" value="{{ $dataBom->id_so }}" required disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault03">Description</label>
            <input type="text" class="form-control" name="uom_bom" value="{{ $dataBom->deskripsi }}" required disabled>
          </div>
        </div>

        <div class="col text-right">
          <a href="{{ route('bom-addmaterial', ['id_bom' => $dataBom->id_bom]) }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Add New Material</a>
        </div>
        <br>

        <!-- <h3>Material Belum Booking</h3> -->
        <div class="table-responsive">
          <table id="unsubmittedDatatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
            <thead>
              <tr class=" justify-content-center" role="row">
              <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                <th style="width: 4rem;text-align: center;">Action</th>
                <th style="width: 4rem;text-align: center;">ID Warehouse</th>
                <th style="width: 4rem;text-align: center;">Work Center</th>
                <th style="width: 15rem; text-align: center">Material Code</th>
                <th>Material Name</th>
                <th>Second Material Name</th>
                <th style="width: 6rem;">UOM</th>
                <th>Comparison</th>
                <th style="width: 6rem;">Composite</th>
                <th>Tolerance(%)</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($detailbom as $detailbomItem)
              <tr role="row" class="odd">
                <td style="text-align: center;">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <a href="{{ route('bom_v2.edit', ['id_materialbom' => $detailbomItem->id_materialbom, 'id_bom' => $dataBom->id_bom]) }}" class="btn btn-primary"><i class="fa-solid fa-edit"></i></a>
                    <button type="button" class="btn btn-primary delete-button" data-id-materialbom="{{ $detailbomItem->id_materialbom }}" data-toggle="modal" data-target="#deleteModal">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </div>
                </td>
                <td>{{ $detailbomItem->id_warehouse1 }}</td>
                <td>{{ $detailbomItem->nama_workcenter }}</td>
                <td>{{ $detailbomItem->id_materialbom }}</td>
                <td>{{ $detailbomItem->nama_materialbom }}</td>
                <td>{{ $detailbomItem->second_material_name }}</td>
                <td>{{ $detailbomItem->uom_material }}</td>
                <td>{{ $detailbomItem->comparison }}</td>
                <td>{{ $detailbomItem->composite }}</td>
                <td>{{ $detailbomItem->tolerance }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>


  <!-- MODAL DELETE MATERIAL -->
  <form id="deleteForm" method="POST" action="">
    @csrf
    @method('DELETE')
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah Anda yakin ingin menghapus item ini?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" form="deleteForm" class="btn btn-danger">Hapus</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal SUBMIT -->
@endsection