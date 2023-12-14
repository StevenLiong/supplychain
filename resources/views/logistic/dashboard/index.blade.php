@extends('logistic.layouts.main')
@section('js')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    {!! $materialStock->script() !!}
    {!! $finishedgoodChart->script() !!}

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
@endsection
@section('content')
    <div class="content-wrapper bg-white">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid px-3">
                <!-- Small boxes (Stat box) -->
                <div class="row mt-3">
                    <div class="col-lg-3 col-6 ">
                        <!-- box in -->
                        <a href="{{ url('scan/information') }}">
                            <div class="small-box">
                                <div class="inner text-dark">
                                    <h3>Scan</h3>

                                    <p>Informasi Material</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-camera"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 ">
                        <!-- box in -->
                        <a href="#">
                            <div class="small-box">
                                <div class="inner text-dark">
                                    <h3>{{ $material->count() }}</h3>

                                    <p>Items Materials</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 ">
                        <!-- box in -->
                        <a href="#">
                            <div class="small-box">
                                <div class="inner text-dark">
                                    <h3>{{ $finishedgood->count() }}</h3>

                                    <p>Stok FinishedGood</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- main content dashboard chart-->
                <div class="row">
                    <section class="col-lg-6 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Data Kedatangan material
                                </h3>
                            </div>
                            <div class="card-body">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Monitoring Stok Material
                                </h3>
                            </div>
                            <div class="card-body">
                                    {!! $materialStock->container() !!}
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Data Stok Finishedgood Per kVA
                                </h3>
                            </div>
                            <div class="card-body">
                                    {!! $finishedgoodChart->container() !!}
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

