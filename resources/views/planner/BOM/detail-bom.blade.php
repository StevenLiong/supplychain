@extends('planner.template.bar')
@section('content')
@section('bill-of-material', 'active')
@section('main', 'show')
<!-- Pastikan library jQuery sudah dimasukkan sebelum Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Tambahkan Bootstrap JS setelah jQuery -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">Detail Bill Of Material</h4>
       </div>
    </div>
    <div class="card-body">
       <form>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">BOM Code</label>
                <input type="text" class="form-control" name="id_bom" value="{{ $dataBom->id_bom }}"required disabled>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault02">Quantity</label>
                <input type="text" class="form-control" name="qty_bom" value="{{ $dataBom->qty_bom }}"required disabled>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefaultUsername">BOM Status</label>
                <div class="input-group">
                <input type="text" class="form-control" name="bom_status" value="{{ $dataBom->bom_status }}"required disabled>
                </div>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault03">UOM BOM</label>
                <input type="text" class="form-control" name="uom_bom" value="{{ $dataBom->uom_bom }}"required disabled>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault03">Sales Order</label>
                <input type="text" class="form-control" name="id_so" value="{{ $dataBom->id_so }}"required disabled>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault05">Kode Finish Good</label>
                <input type="text" class="form-control" name="id_fg" value="{{ $dataBom->id_fg }}"required disabled>
             </div>
             <div class="col-md-6 mb-3">
               <label for="validationDefault05">Status</label>
               <input type="text" class="form-control" value="{{ $status }}" required disabled>
            </div>
            <div class="col-md-6 mb-3">
               <label for="validationDefault05">Keterangan</label>
               <input type="text" class="form-control" value="{{ $keterangan }}" required disabled>
            </div>
        </div>

        <div class="col text-right">
           <a href="{{ route('bom-addmaterial', ['id_bom' => $dataBom->id_bom]) }}" class="btn btn-primary"><i class="mr-2 fa fa-plus" aria-hidden="true"></i>Add New Material</a>
        </div>
        <br>

        <h3>Material Belum Submit</h3>
            <div class="table-responsive">
                <table id="unsubmittedDatatable" class="table data-table table-striped dataTable" role="grid"aria-describedby="datatable_info">
                <thead>
                     <tr class=" justify-content-center" role="row">
                     <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                         <th style="width: 4rem;text-align: center;">Action</th>
                         <th style="width: 4rem;text-align: center;">Work Center</th>
                         <th style="width: 15rem; text-align: center">Material Code</th>
                         <th>Material Name</th>
                         <th style="width: 6rem;">UOM</th>
                         <th>Composite</th>
                         <th style="width: 6rem;">Quantity</th>
                         <th>Tolerance(%)</th>
                         <th>Total</th>
                         <th>Keterangan</th>
                     </tr>
                 </thead>
                    <tbody>
                        @foreach ($unsubmittedDetailBom as $detailbomItem)
                        <tr role="row" class="odd">
                           <td style="text-align: center;">
                              <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                 <a href="{{ route('bom.edit', ['id_materialbom' => $detailbomItem->id_materialbom, 'id_bom' => $dataBom->id_bom]) }}" class="btn btn-primary"><i class="fa-solid fa-edit"></i></a>
                                 <button type="button" class="btn btn-primary delete-button" data-id-materialbom="{{ $detailbomItem->id_materialbom }}" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fa-solid fa-trash"></i>
                                 </button>
                              </div>
                           </td>
                           <td>{{ $detailbomItem->nama_workcenter }}</td>
                           <td>{{ $detailbomItem->id_materialbom }}</td>
                           <td>{{ $detailbomItem->nama_materialbom }}</td>
                           <td>{{ $detailbomItem->uom_material }}</td>
                           <td>{{ $detailbomItem->qty_trafo }}</td>
                           <td>{{ $detailbomItem->qty_material }}</td>
                           <td>{{ $detailbomItem->tolerance }}</td>
                           <td>{{ $detailbomItem->usage_material }}</td>
                           <td>{{ $detailbomItem->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
<br>
        <form action="{{ route('bom.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="id_bom" value="{{ $id_bom }}">
            
            <!-- Tambahkan input hidden untuk setiap detail BOM -->
            @foreach ($detailbom as $detailbomItem)
               <input type="hidden" name="id_boms[{{ $detailbomItem->id_materialbom }}][id_materialbom]" value="{{ $detailbomItem->id_materialbom }}">
               <input type="hidden" name="id_boms[{{ $detailbomItem->id_materialbom }}][usage_material]" value="{{ $detailbomItem->usage_material }}">
               <input type="hidden" name="id_boms[{{ $detailbomItem->id_materialbom }}][db_status]" value="{{ $detailbomItem->db_status }}">
            @endforeach

            <!-- Tampilkan tombol Submit hanya jika semua db_status adalah 1 -->
            @if ($detailbom->every(function ($item) { return $item->db_status == 1; }))
               <button type="submit" class="btn btn-primary">Submit</button>
            @else
               <p class="text-danger">Tidak dapat submit, beberapa material belum terpenuhi.</p>
            @endif
         </form>
<br>
         <!-- Tabel Data yang Sudah di-Submit -->
         <h3>Material Sudah Submit</h3>
         <div class="table-responsive">
               <table id="submittedDatatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                  <thead>
                        <tr class=" justify-content-center" role="row">
                        <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                           <th style="width: 4rem;text-align: center;">Action</th>
                           <th style="width: 4rem;text-align: center;">Work Center</th>
                           <th style="width: 15rem; text-align: center">Material Code</th>
                           <th>Material Name</th>
                           <th style="width: 6rem;">UOM</th>
                           <th>Composite</th>
                           <th style="width: 6rem;">Quantity</th>
                           <th>Tolerance(%)</th>
                           <th>Total</th>
                           <th>Keterangan</th>
                        </tr>
                  </thead>
                  <tbody>
                     @foreach ($submittedDetailBom as $detailbomItem)
                     <tr role="row" class="odd">
                           <td style="text-align: center;">
                           <form action="{{ route('bommaterial.restore', ['id_materialbom' => $detailbomItem->id_materialbom, 'id_bom' => $dataBom->id_bom]) }}" method="POST" onsubmit="return confirm('Yakin ingin merestore material ini?');">
                                 @csrf
                                 <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Restore</button>
                           </form>
                           </td>
                           <td>{{ $detailbomItem->nama_workcenter }}</td>
                           <td>{{ $detailbomItem->id_materialbom }}</td>
                           <td>{{ $detailbomItem->nama_materialbom }}</td>
                           <td>{{ $detailbomItem->uom_material }}</td>
                           <td>{{ $detailbomItem->qty_trafo }}</td>
                           <td>{{ $detailbomItem->qty_material }}</td>
                           <td>{{ $detailbomItem->tolerance }}</td>
                           <td>{{ $detailbomItem->usage_material }}</td>
                           <td>{{ $detailbomItem->keterangan }}</td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
         </div>
       </form>
    </div>
 </div>

 <form id="deleteForm" method="POST" action="{{ route('bommaterial.delete', ['id_materialbom' => '_ID_MATERIALBOM_', 'id_bom' => $dataBom->id_bom]) }}">
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

<button
  type="button"
  class="btn btn-primary delete-button"
  data-toggle="modal"
  data-target="#deleteModal"
  data-id-materialbom="{{ $detailbomItem->id_materialbom }}"
>
  <i class="fa-solid fa-trash"></i> Delete
</button>

<!-- Sertakan jQuery sebelum menyertakan Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
   // Fungsi untuk mengatur nilai data-id-materialbom sebelum modal ditampilkan
   $('#deleteModal').on('show.bs.modal', function (event) {
   const button = $(event.relatedTarget); // Tombol yang memunculkan modal
   const idMaterialbom = button.data('id-materialbom'); // Ambil nilai data-id-materialbom dari tombol
   // Setel nilai data-id-materialbom di dalam modal dan dalam formulir
   $(this).data('id-materialbom', idMaterialbom);
   $('#deleteForm').attr('action', "{{ route('bommaterial.delete', ['id_materialbom' => '_ID_MATERIALBOM', 'id_bom' => $dataBom->id_bom]) }}".replace('__ID_MATERIALBOM_', idMaterialbom));
   });

   // Fungsi untuk mengirim form secara asynchronous menggunakan AJAX
   $('#deleteForm').on('submit', function (event) {
   event.preventDefault(); // Mencegah formulir dikirim secara default
   const formAction = $(this).attr('action'); // Ambil action dari formulir
   $.ajax({
      type: 'POST',
      url: formAction,
      data: $(this).serialize(), // Kirim data formulir
      success: function(response) {
         // Tanggapan dari server, atur tindakan yang sesuai di sini
         console.log(response);
         // Tutup modal setelah berhasil menghapus jika diperlukan
         $('#deleteModal').modal('hide');
         
         // Arahkan pengguna kembali ke halaman detailBom setelah berhasil menghapus
         window.location.href = "{{ route('bom.detailbom', ['id_bom' => $dataBom->id_bom]) }}";
      },
      error: function(error) {
         console.error('Error:', error);
      }
   });
   });
   
</script>


@endsection