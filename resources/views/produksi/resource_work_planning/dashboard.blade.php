@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-lg-12">
        <div class="row mb-4 align-items-center">
            <div class="dropdown status-dropdown ml-2 dropdown-toggl" id="dropdownMenuButton03" data-toggle="dropdown"
                aria-expanded="false">
                <div class="btn btn-primary">Periode<i class="ri-arrow-down-s-line ml-2 mr-0"></i></div>
                <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenuButton03">
                    <a class="dropdown-item" href="#"> 1 Minggu</a>
                    <a class="dropdown-item" href="#"> 2 Minggu</a>
                    <a class="dropdown-item" href="#"> 3 Minggu</a>
                </div>
            </div>
        </div>
        <div class="card bg-primary">
            <div class="row">
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card-body">
                        <div class="card text-center">
                            <div class="card-header m-0 p-0 px-1 py-1">
                                <h6 >Quantity</h6>
                            </div>
                            <div class="card-body  text-primary m-0 p-0 px-3 py-2">
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>Product Line 2</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>Product Line 3</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>CT / VT</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>DRY</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="header-title">
                    <h4 class="card-title mt-2 mb-5"><b>REPAIR</b></h4>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Quantity</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kapasitas (%)</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Kebutuhan MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Selisih MP</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card card-widget task-card">
                            <div class="card-body text-center">
                                <h6>Overtime</h6>
                                <h3>4</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"><b>100%</b></div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><b>25%</b></div>
                </div>

                <div class="mt-2" style=" vertical-align: middle;">
                    <span class="badge badge-warning mr-1" style="height: 15px"> </span> Over Capacity
                </div>
            </div>
        </div>

    </div>
@endsection
