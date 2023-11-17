@extends('template.bar')
@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">

                <h4 class="card-title">Work Order</h4>
            </div>
        </div>
        <div class="card-body">



            <div class="row d-flex mb-4">
                <div class="col  text-left">
                    <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                    <a href="#" class="MR-3 btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa fa-table"></i>Download Exel</a>
                </div>

                <div class="col  text-right">
                    <a href="/WO/Create-Work-Order" class="btn btn-primary"><i class=" mr-2 fa fa-plus" aria-hidden="true"></i>Create WO</a>
                </div>

            </div>
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                            <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 4rem;text-align: center;">No</th>

                                <th style="width: 15rem;" class="text-center">Work Order</th>
                                <th>BOM Code</th>
                                <th style="width: 6rem;" class="text-center">Manhour Code</th>
                                <th class="text-center">Sales Order</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Action</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">1</td>

                                <td class="text-center">xxxxxxxxxxxxxxxx</td>
                                <td class="text-center">WARINO</td>
                                <td style="text-align: center;">4</td>
                                <td class="text-center">xxxxxxxxxxxxxxxx</td>                                
                                <td style="text-align: center;">4</td>
                                <td style="text-align: center;">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button type="button" class="btn btn-primary" onclick="window.location.href='/WO/Edit-Work-Order'">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary" id="showModalBtn" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                        <!-- modal yes no -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header merah">
                                        <h5 class="modal-title text-putih" id="exampleModalLabel">Confirmation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this item?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-white" data-dismiss="modal">No</button>
                                        <button type="button" class="btn btn-success text-white" id="yesButton" onclick="window.location.href='/Work-Order'">Yes</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection