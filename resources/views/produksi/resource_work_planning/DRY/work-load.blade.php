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
                                    <th></th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        <th>
                                            @if ($kap->ukuran_kapasitas)
                                                {{ $kap->ukuran_kapasitas }}
                                            @endif
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>

                                </tr>
                                
                                <tr>
                                    <td>Coil LV</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>Coil HV</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>CCA</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                </tr>
                                <tr>
                                    <td>Mould & Casting</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                </tr>                                 
                                <tr>
                                    <td>QC</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                    <td>6</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
