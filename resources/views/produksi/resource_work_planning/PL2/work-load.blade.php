@extends('produksi.resource_work_planning.template.layout')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Work Load</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center">
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
                                    <th colspan="12">
                                        1 Minggu
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width: 150px; vertical-align: middle;">Proses</th>
                                    <th colspan="5">KVA PLN</th>
                                    <th colspan="5">KVA SWASTA</th>
                                </tr>
                                <tr>
                                    <th>10</th>
                                    <th>20</th>
                                    <th>30</th>
                                    <th>40</th>
                                    <th>50</th>
                                    <th>10</th>
                                    <th>20</th>
                                    <th>30</th>
                                    <th>40</th>
                                    <th>50</th>

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <th>Coil LV</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>Coil HV</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>CCA</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>Connect</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>Final</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>QC</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
