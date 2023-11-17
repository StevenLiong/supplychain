@extends('template.bar')
@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Detail GPA Trafo Dry Type</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row d-flex mb-4">
                <div class="col  text-left">
                    <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa-regular fa-file-pdf"></i>Download PDF</a>
                    <a href="#" class="MR-3 btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i class="mr-2 fa fa-table"></i>Download Exel</a>
                </div>
            </div>
            <table>
                <tr>
                    <td style="width: 6rem;">Work Order</td>
                    <td style="width: 7rem;"><input type="text" class="form-control" id="validationDefault01" value="W1230293FA" readonly></td>
                    <td style="width: 4rem" class="text-center">Line</td>
                    <td style="width: 5rem"><input type="text" class="form-control text-center" id="validationDefault02" value="3"readonly></td>
                    <td style="width: 4rem" class="text-center">KVA</td>
                    <td style="width: 5rem"><input type="text" class="form-control text-center" id="validationDefault03" value="1600"readonly></td>
                    <td style="width: 5rem" class="text-center">Quantity</td>
                    <td style="width: 5rem"><input type="text" class="form-control text-center" id="validationDefault04" value="3"readonly></td>
                    <td style="width: 12rem" class="text-center">Kode Resource Planning</td>
                    <td style="width: 7rem"><input type="text" class="form-control text-center" id="validationDefault05" value="RP123"readonly></td>
                </tr>
            </table>
            <div class="table-responsive" style="margin-top: 1rem">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table table-striped dataTable">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                                <th style="width: 15rem;text-align: center;">Work Center</th>
                                <th style="width: 15rem;text-align:center">Dead Line</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1">Bill of Material</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Insulation Paper</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Supply Material Insulation & Coil</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">LV Windling</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">HV Windling</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Core</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Supply Fixing Parts & Core</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Moulding</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Supply Material Connection & FA</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">Connection & FA</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">QC</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center" class="sorting_1">QC Transfer Gudang</td>
                                <td style="text-align: center">DD-MMMM-YYYY</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection