@extends('purchaser.layout.layoutmr.wraplayoutmr')

@section('title', 'reportmr')
@section('contentmr')

<!-- Tautan ke jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Tautan ke pustaka DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card p-4 rounded-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-start text-dark my-4" style="font-weight: bold;">Daftar Material Request</h3>
                <a href="adddatamaterialmr" class="btn btn-danger text-white mt-5 mb-1">
                    Add Material
                    <i class="fas fa-plus-square ms-2"></i>
                </a>
            </div>
            <hr class="mt-1" style="background-color: black;">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">MR NO</th>
                            <th scope="col">Status MR</th>
                            <th scope="col">Tanggal Terima</th>
                            <th scope="col">Keterangan MR</th>
                            <th scope="col">PO NO</th>
                            <th scope="col">Status PO</th>
                            <th scope="col">Tanggal Kirim</th>
                            <th scope="col">Keterangan PO</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @foreach ($dataMr as $no => $addmaterial)
                    <tbody class="text-center">
                        <tr>
                            <th>{{ $no + 1 }}</th>
                            <td>{{ $addmaterial->id_mr}}</td>
                            <td>{{ $addmaterial->status_mr}}</td>
                            <td>{{ $addmaterial->accepted_mr}}</td>
                            <td>{{ $addmaterial->keterangan}}</td>
                            <td>{{ $addmaterial->po ? $addmaterial->po->id_po : '-'}}</td>
                            <td>{{ $addmaterial->po ? $addmaterial->po->status_po : '-'}}</td>
                            <td>{{ $addmaterial->po ? $addmaterial->po->tanggal_kirim : '-'}}</td>
                            <td>{{ $addmaterial->po ? $addmaterial->po->keterangan : '-'}}</td>
                            <td>
                                <a href="" class="pdf-link btn " type="button">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </a>
                                <a href="" class="pdf-link btn " type="button">
                                    <i class="bi bi-file-earmark-excel-fill"></i>
                                </a>
                                <a href="" class="pdf-link btn " type="button" data-bs-toggle="modal" data-bs-target="">
                                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Tambahkan entri lain sesuai kebutuhan -->
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Tombol "Add Data" di sini -->
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            paging: true,
            lengthChange: true,
            pageLength: 5,
            dom: '<"top"lfB<"text-end"i>tp>',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    });
</script>


@endsection