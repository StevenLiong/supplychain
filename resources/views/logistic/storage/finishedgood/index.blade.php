@extends('logistic.layouts.main')
@section('content')
        <!-- Main content -->
        <section class="content">
            <div class="content-wrapper bg-white">
                <div class="container-fluid">
                    {{-- headline --}}
                    <div class="row">
                        <div class="col-12 px-3">
                            <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                                <h4 class="text-bold m-0
                                ">Finished Good CTVT</h4>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row mt-3">
                            <div class="col-lg-3 col-6">
                                <!-- Put Away -->
                                <a href="{{ url('storage/scan') }}">
                                    <div class="small-box">
                                        <div class="icon">
                                            <svg width="24" height="24" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22.7 15.999H10.3M10.3 15.999L15.725 21.249M10.3 15.999L15.725 10.749" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.5 31C25.0603 31 32 24.2842 32 16C32 7.71572 25.0603 1 16.5 1C7.93958 1 1 7.71572 1 16C1 24.2842 7.93958 31 16.5 31Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                        </div>
                                            <div class="inner text-dark">
                                                <h5>Put Away</h5>
                                            </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- Rack Checking -->
                                {{-- <a href="{{ route('rackchecking.blade.php') }}"> --}}
                                    <div class="small-box">
                                        <div class="inner text-dark">
                                            <h5>Rack Checking</h5>
                                        </div>
                                        <div class="icon">
                                            <svg width="24" height="24" viewBox="0 0 32 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M23 22.25L30 29" stroke="black" stroke-opacity="0.8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2 13.5714C2 19.9621 7.37258 25.1429 14 25.1429C17.3194 25.1429 20.3242 23.8432 22.4966 21.7428C24.6616 19.6497 26 16.7613 26 13.5714C26 7.1807 20.6274 2 14 2C7.37258 2 2 7.1807 2 13.5714Z" stroke="black" stroke-opacity="0.8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                
                                            {{-- <i class="ion ion-bag"></i> --}}
                                        </div>
                                    </div>
                                {{-- </a> --}}
                            </div>
                        </div>
                    </div>
        </section>
    </div>
@endsection
