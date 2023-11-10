@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12 px-3">
                        <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                            <h4 class="text-bold m-0
                        ">Receiving Scan</h4>
                        </div>
                    </div>
                </div>


                <!-- Small boxes (Stat box) -->
                <div class="row mt-3 px-3">
                    <div class="col-lg-3 col-6 ">
                        <!-- box in -->
                        <a href="{{ url('scan/information') }}">
                            <div class="small-box ">
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
                        <a href="{{ url('receiving/scan/stockin') }}">
                            <div class="small-box ">
                                <div class="inner text-dark">
                                    <h3>Scan</h3>

                                    <p>Stock In</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-camera"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
