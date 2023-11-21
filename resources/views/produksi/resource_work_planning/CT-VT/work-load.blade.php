@extends('produksi.resource_work_planning.template.bar')
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
                                    <th colspan="10">TYPE</th>
                                </tr>
                                <tr>
                                    <th>TCI-24-2D</th>
                                    <th>TCI-24-3B2/2B/2E/3C (Single Ratio)</th>
                                    <th>TCI-24-3B2/2B/2E/3C (Double Ratio)</th>
                                    <th>TCI-24-4B CT CORONG</th>
                                    <th>TCI-24-4C CT BAMBU</th>
                                    <th>CT-24(O) 1C1R/2R</th>

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <th>Coil CT</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>Coil VT</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>Mould & Casting</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                    <th>6</th>
                                </tr>
                                <tr>
                                    <th>Final Assembly</th>
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
