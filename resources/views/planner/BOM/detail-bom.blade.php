@extends('planner.template.bar')
  @section('content')
  @section('bill-of-material', 'active')
@section('main', 'show')
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
            <input type="text" class="form-control" name="id_bom" value="{{ $dataBom->id_bom }}" required disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault02">Quantity</label>
            <input type="text" class="form-control" name="qty_bom" value="{{ $dataBom->qty_bom }}" required disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefaultUsername">BOM Status</label>
            <div class="input-group">
              <input type="text" class="form-control" name="bom_status" value="{{ $dataBom->bom_status }}" required disabled>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault03">UOM BOM</label>
            <input type="text" class="form-control" name="uom_bom" value="{{ $dataBom->uom_bom }}" required disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault03">Sales Order</label>
            <input type="text" class="form-control" name="id_so" value="{{ $dataBom->id_so }}" required disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="validationDefault05">Kode Finish Good</label>
            <input type="text" class="form-control" name="id_fg" value="{{ $dataBom->id_fg }}" required disabled>
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
          <table id="unsubmittedDatatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
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
        @if ($detailbom->every(function ($item) { return $item->db_status == 1; }))
        <button type="button" class="btn btn-primary" id="confirmSubmitButton" data-toggle="modal" data-target="#confirmationModal">
          Submit
        </button>
        @else
        <p class="text-danger">Tidak dapat submit, beberapa material belum terpenuhi.</p>
        @endif
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
                  <!-- Tambahkan tombol Restore -->


                  <button type="button" class="btn btn-primary restore-button" data-id-materialbom="{{ $detailbomItem->id_materialbom }}" data-toggle="modal" data-target="#restoreModal_{{ $detailbomItem->id_materialbom }}">
                    <i class="fa-solid fa-plus"></i> Restore
                  </button>

                  <!-- Tambahkan satu elemen modal -->
                  <form id="restoreForm{{ $detailbomItem->id_materialbom }}" action="{{ route('bommaterial.restore', ['id_materialbom' => $detailbomItem->id_materialbom, 'id_bom' => $dataBom->id_bom]) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="restoreModal_{{ $detailbomItem->id_materialbom }}" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel_{{ $detailbomItem->id_materialbom }}" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="restoreModalLabel_{{ $detailbomItem->id_materialbom }}">Konfirmasi Restore</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin merestore item ini?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary confirmRestoreButton" data-id-materialbom="{{ $detailbomItem->id_materialbom }}">Restore</button>
                          </div>
                        </div>
                      </div>
                    </div>
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
  <form id="submitForm" action="{{ route('bom.submit') }}" method="POST">
    @csrf
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Submit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_bom" value="{{ $id_bom }}">

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </form>

 <script>
    $(document).ready(function() {

      //JAVASCRIPT UNTUK SUBMIT MATERIAL
      // Menggunakan variabel global untuk menyimpan data yang akan dikirim
      let submitData = {};

      $('#submit-button').on('click', function() {
        // Reset data pada setiap klik tombol submit
        submitData = {};

        // Kumpulkan data yang diperlukan dari formulir atau sumber lainnya
        submitData.id_bom = '{{ $id_bom }}';

        // Tampilkan modal konfirmasi
        $('#confirmationModal').modal('show');
      });

      // Handle klik tombol submit di dalam modal konfirmasi
      $('#confirmSubmitButton').on('click', function() {
        // Kirim data ke server menggunakan AJAX
        $.ajax({
          type: 'POST',
          url: '{{ route("bom.submit") }}',
          data: {
            _token: '{{ csrf_token() }}',
            id_bom: submitData.id_bom,
          },
          success: function(response) {
            // Close the confirmation modal after successful submission
            $('#confirmationModal').modal('hide');

            // Redirect the user back to the same page
            window.location.href = window.location.href;
          },
          error: function(error) {
            console.error('Error:', error);
          },
        });
      });
      
      //=================================================================================================
      //JAVASCRIPT DELETE MATERIAL
      // Fungsi untuk mengatur nilai data-id-materialbom sebelum modal ditampilkan
      $('#deleteModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget); // Tombol yang memunculkan modal
        const idMaterialbom = button.data('id-materialbom');
        // Setel nilai data-id-materialbom di dalam modal dan dalam formulir
        $(this).data('id-materialbom', idMaterialbom);

        // Perbarui aksi formulir untuk mencantumkan id_materialbom
        const deleteForm = $('#deleteForm');
        const actionUrl = "{{ route('bommaterial.delete', ['id_materialbom' => ':id_materialbom', 'id_bom' => $dataBom->id_bom]) }}";
        deleteForm.attr('action', actionUrl.replace(':id_materialbom', idMaterialbom));
      });

      // Fungsi untuk mengirim form secara asynchronous menggunakan AJAX
      $('#deleteForm').on('submit', function(event) {
        event.preventDefault(); // Mencegah formulir dikirim secara default
        // Kirim data ke server menggunakan AJAX
        $.ajax({
          type: 'POST',
          url: $(this).attr('action'),
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
            // Tampilkan pesan error
            console.error('Error:', error);
          },
        });
      });

    //=================================================================================================
    //JAVASCRIPT RESTORE MATERIAL

  // Function to get CSRF token from the page
  function getCsrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
  }

  // Fungsi untuk mengatur nilai data-id-materialbom sebelum modal ditampilkan
  $('.restore-button').on('click', function() {
    console.log('Button clicked');
    var idMaterialbom = $(this).data('id-materialbom');
    console.log('ID Materialbom:', idMaterialbom);

    // Tampilkan modal restore
    $('#restoreModal' + idMaterialbom).modal('show');
  });

  // Handle click event on the "Restore" button inside the restore modal
  $('.confirmRestoreButton').on('click', function() {
    var idMaterialbom = $(this).data('id-materialbom');
    var idBom = "{{ $dataBom->id_bom }}"; // Get the id_bom value from Blade

    var url = "{{ route('bommaterial.restore', ['id_materialbom' => ':id_materialbom', 'id_bom' => ':id_bom']) }}";
    url = url.replace(':id_materialbom', idMaterialbom).replace(':id_bom', idBom);

    // Lakukan permintaan AJAX dengan URL yang telah diperbarui
    $.ajax({
      type: 'POST',
      url: url,
      data: {
        _token: getCsrfToken(),
        id_materialbom: idMaterialbom,
        id_bom: idBom,
        // Add any other data you need to send
      },
      success: function(response) {
        // Handle the success response
        console.log(response);
        $('#restoreModal' + idMaterialbom).modal('hide');
        window.location.href = "{{ route('bom.detailbom', ['id_bom' => $dataBom->id_bom]) }}";
        // Optionally, you can redirect or perform other actions based on the response
      },
      error: function(error) {
        // Handle the error
        console.error('Error:', error);
        // Optionally, display an error message to the user
      },
    });
});

    });
  </script>
  @endsection