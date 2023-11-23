@extends('purchaser.layout.layoutmr.wraplayoutmr')

@section('title', 'materialrequest')
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
                            <th scope="col">PR NO</th>
                            <th scope="col">Date</th>
                            <th scope="col">Divison Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">PO Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <th scope="row">1</th>
                            <td>09284923890</td>
                            <td>A123982791</td>
                            <td>
                                <div>DGA</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>09284923890</td>
                            <td>A123982791</td>
                            <td>
                                <div>DGA</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>09284923890</td>
                            <td>A123982791</td>
                            <td>
                                <div>DGA</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td>09284923890</td>
                            <td>A123982791</td>
                            <td>
                                <div>DGA</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <!-- Tambahkan entri lain sesuai kebutuhan -->
                    </tbody>
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