@extends('template.bar')
@section('content')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Global Picking Area Trafo Dry Type</h4>
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
                                <th style="width: 4rem;text-align: center;">WO</th>
                                <th style="width: 15rem;text-align:center">Project Name</th>
                                <th style="text-align: center">Line</th>
                                <th style="width: 6rem; text-align:center">KVA</th>
                                <th style="text-align: center">Quantity</th>
                                <th style="width: 6rem; text-align: center">Lead Time (Hari)</th>
                                <th style="text-align: center">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row" class="odd">

                                <td style="text-align: center;" class="sorting_1"><a href="/GPA/Detail-GPA-Dry">W1230293FA</a></td>
                                <td style="text-align: center">PALEM GUNUNGMAS SEJAHTERA</td>
                                <td style="text-align: center">3</td>
                                <td style="text-align: center;">1600</td>
                                <td style="text-align: center">3</td>
                                <td style="text-align: center">8</td>
                                <td style="text-align: center; width: 7rem">27 Oktober 2023</td>
                            </tr>
                            <tr role="row" class="odd">
                                <td style="text-align: center;" class="sorting_1"><a href="/GPA/Detail-GPA-Dry">W1230293FA</a></td>
                                <td style="text-align: center">PALEM GUNUNGMAS SEJAHTERA</td>
                                <td style="text-align: center">3</td>
                                <td style="text-align: center;">1600</td>
                                <td style="text-align: center">3</td>
                                <td style="text-align: center">8</td>
                                <td style="text-align: center; width: 7rem">27 Oktober 2023</td>
                            </td>


                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection