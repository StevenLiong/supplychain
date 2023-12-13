@extends('purchaser.layout.layoutpo.wraplayoutpo')

@section('title', 'reportpo')
@section('contentpo')


<!-- Tautan ke jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Tautan ke pustaka DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card p-4 rounded-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-start text-dark my-4" style="font-weight: bold;">List Purchase Order</h3>
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
                    @foreach ($dataPo as $no => $addmaterial)
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

<!-- Modal -->
<div class="modal fade" id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">List Material</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Kode Material</th>
                            <th scope="col">Nama Material</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="table-plus"></td>
                            <td class="table-plus"></td>
                            <td class="table-plus"></td>
                            <td class="table-plus"></td>
                            <td class="table-plus"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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