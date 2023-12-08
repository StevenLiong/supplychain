@extends('logistic.layouts.main')
@section('js')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();
        });
    </script>
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

                                    <p>Materials</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-6 ">
                        <!-- box in -->
                        <a href="#">
                            <div class="small-box">
                                <div class="inner text-dark">
                                    <h3>{{ $supplier->count() }}</h3>

                                    <p>Supplier</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- main content dashboard chart-->
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
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
                    <section class="col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Kalender 2023
                                </h3>
                            </div>
                            <div class="card-body">
                                    <div class="p" id='calendar'></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

