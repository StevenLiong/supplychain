@extends('produksi.resource_work_planning.template.layout')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Jumlah Man Power dan Mesin</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center">
                    <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03" data-toggle="dropdown"
                        aria-expanded="false">
                        <div class="btn btn-primary">Hour / Day<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> 7 Jam</a>
                            <a class="dropdown-item" href="#"> 8 Jam</a>
                            <a class="dropdown-item" href="#"> 10 Jam</a>
                        </div>
                    </div>
                    <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03"
                        data-toggle="dropdown" aria-expanded="false">
                        <div class="btn btn-primary">Shift<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> 1 </a>
                            <a class="dropdown-item" href="#"> 2 </a>
                            <a class="dropdown-item" href="#"> 3 </a>
                        </div>
                    </div>
                    <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03"
                        data-toggle="dropdown" aria-expanded="false">
                        <div class="btn btn-primary">Work Center<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                        <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                            <a class="dropdown-item" href="#"> Untanking</a>
                            <a class="dropdown-item" href="#"> Bongkar</a>
                            <a class="dropdown-item" href="#"> Coil Making</a>
                            <a class="dropdown-item" href="#"> CCA</a>
                            <a class="dropdown-item" href="#"> Connect</a>
                            <a class="dropdown-item" href="#"> Final Assembly</a>
                            <a class="dropdown-item" href="#"> Finishing</a>
                            <a class="dropdown-item" href="#"> QC Testing</a>
                        </div>
                    </div>
                    <div class="ml-auto mr-3" style="align-items: d-flex right;">
                        <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i
                                class="mr-2 fa-solid fa-print"></i>Print</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        <table id="datatable" class="table data-table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="text-center ">

                                <tr>
                                    <th rowspan="2" style="width: 150px; vertical-align: middle;">Kapasitas</th>
                                    <th colspan="2">Jumlah Man Power</th>
                                    <th colspan="2">Jumlah Mesin</th>
                                </tr>
                                <tr>
                                    <th>Coil LV</th>
                                    <th>Coil HV</th>
                                    <th>Coil LV</th>
                                    <th>Coil HV</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <th>10</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                </tr>
                                <tr>
                                    <th>15</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                </tr>
                                <tr>
                                    <th>20</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                </tr>
                                <tr>
                                    <th>30</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                </tr>
                                <tr>
                                    <th>50</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                    <th>2</th>
                                </tr>
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th>Total</th>
                                    <th>20</th>
                                    <th>15</th>
                                    <th>20</th>
                                    <th>15</th>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <th>-3</th>
                                    <th>1</th>
                                    <th>-1</th>
                                    <th>-2</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
