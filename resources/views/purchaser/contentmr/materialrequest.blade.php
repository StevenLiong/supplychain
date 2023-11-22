@extends('layout.layoutmr.wraplayoutmr')

@section('title', 'materialrequest')
@section('contentmr')

<!-- Tautan ke jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Tautan ke pustaka DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<p style="font-size: 23px; color: black;">Material Request</p>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-4" style="border-left-color: red; border-left-width: 10px;">
            <div class="card-body shadow">
                <h6 class="text-start font-weight-bold " style="color: black;">Form Pengisian Pembuatan Material Request Pada Halaman Ini.</h6>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card p-4 rounded-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="text-start text-dark my-4" style="font-weight: bold;">List Order</h3>
                <a href="/materialrequest/add" class="btn btn-danger text-white mt-5 mb-1">
                    Add Data
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
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col">Divison Name</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">PO Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @foreach ($dataMr as $no => $addmaterial)
                    <tbody class="text-center">
                        <tr>
                            <td class="table-plus">{{ $no + 1 }}</td>
                            <td class="table-plus">{{ $addmaterial->id_mr }}</td>
                            <td class="table-plus">{{ $addmaterial->status_mr }}</td>
                            <td class="table-plus">{{ $addmaterial->tanggal_mr }}</td>
                            <td class="table-plus">{{ $addmaterial->division->name_division }}</td>
                            <td class="table-plus">{{ $addmaterial->keterangan }}</td>
                            <td class="table-plus"></td>
                            <td>
                                <a href="/materialrequest/{{$addmaterial->id_mr}}" class="pdf-link btn " type="button">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/materialrequest/delete/{{$addmaterial->id_mr}}" class="pdf-link btn " type="button" >
                                    <i class="bi bi-trash3"></i> 
                                </a>
                            </td>

                        </tr>
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