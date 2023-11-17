@extends('template.bar')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Data $title2</h4>
            </div>
        </div>
        <div class="card-body">
            <!-- <div class="d-flex flex-wrap align-items-center justify-content-center breadcrumb-content"> -->
            <div class="row mb-4 align-items-center ">
                <button type=" button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal" style="align-items: d-flex">
                    Create Data <i class="ml-2 fa-solid fa-plus"></i>
                </button>
                <div class="ml-auto mr-3" style="align-items: d-flex right;">
                    <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa-solid fa-print"></i>Print</a>
                </div>
            </div>
            <div class="table-responsive mt-5">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th>QTY Total</th>
                                <th>Rate Work</th>
                                <th>Total Man Hour</th>
                                <th>Total Man Power</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td class="sorting_1">Airi Satou</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>33</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">Angelica Ramos</td>
                                <td>Chief Executive Officer (CEO)</td>
                                <td>London</td>
                                <td>47</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1">Airi Satou</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>33</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- modal create data  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">QTY</span>
                    </div>
                    <input type="text" class="form-control" placeholder="QTY" aria-label="QTY" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Rate Work </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Rate Work " aria-label="Rate Work " aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection