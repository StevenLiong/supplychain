@extends('template.bar')
@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Stock</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col  text-left">
                    <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                    <a href="#" class="MR-3 btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa fa-table"></i>Download Exel</a>
                </div>
            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                            <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 1rem;text-align: center;">No</th>
                                <th style="width: 6rem; text-align: center">Kode Item</th>
                                <th style="width: 9rem; text-align: center">Nama Item</th>
                                <th style="width: 2rem; text-align: center">Safety Stock</th>
                                <th style="width: 1rem; text-align: center">ROP</th>
                                <th style="width: 4rem; text-align: center">Maximum Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">1</td>
                                <td style="text-align: center">RTBA01003</td>
                                <td style="text-align: center">Aluminium Sheet</td>
                                <td style="text-align: center;">100</td>
                                <td style="text-align: center">50</td>
                                <td style="text-align: center">500</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection