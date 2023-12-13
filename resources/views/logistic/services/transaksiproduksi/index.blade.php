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
                                ">Transaksi Produksi Menu</h4>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    @if ($countCutting > 0)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Pemberitahuan!</strong> Anda memiliki
                            <a href="{{ url('services/transaksiproduksi/listpending') }}" class="alert-link">
                                {{ $countCutting }} pengiriman menunggu tanggapan
                            </a>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Small boxes (Stat box) -->
                    <div class="row mt-3">
                        <div class="col-lg-3 col-6 ">
                            <!-- box in -->
                            <a href="{{ url('/services/transaksiproduksi/stok') }}">
                                <div class="small-box ">
                                    <div class="inner text-dark">
                                        <h3>Stok</h3>

                                        <p>Stok Produksi</p>
                                    </div>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M12 20q-3.506 0-5.753-.893Q4 18.213 4 16.807V7q0-1.246 2.34-2.123Q8.678 4 12 4t5.66.877Q20 5.754 20 7v9.808q0 1.405-2.247 2.299Q15.506 20 12 20Zm0-11.11q2.148 0 4.33-.599q2.183-.599 2.612-1.304q-.41-.745-2.57-1.366T12 5q-2.179 0-4.366.599q-2.188.6-2.615 1.31q.408.75 2.576 1.366Q9.763 8.89 12 8.89Zm0 5.033q1.03 0 2.025-.1t1.901-.297q.907-.197 1.685-.491q.777-.295 1.389-.664V8.275q-.612.37-1.39.663q-.777.295-1.684.492q-.907.197-1.901.297t-2.025.1q-1.07 0-2.079-.11q-1.01-.11-1.907-.306q-.897-.198-1.662-.482Q5.587 8.644 5 8.275v4.096q.587.37 1.352.654t1.662.482q.898.197 1.907.306q1.01.11 2.079.11ZM12 19q1.285 0 2.443-.146t2.082-.415q.923-.268 1.57-.64q.645-.372.905-.805v-3.623q-.612.37-1.39.664q-.777.294-1.684.491q-.907.197-1.901.297t-2.025.1q-1.07 0-2.079-.11q-1.01-.11-1.907-.306q-.897-.197-1.662-.482q-.765-.285-1.352-.654V17q.26.452.903.812q.643.36 1.566.627q.923.269 2.085.415Q10.715 19 12 19Z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 ">
                            <!-- box in -->
                            <a href="{{ url('/services/transaksiproduksi/transfer') }}">
                                <div class="small-box ">
                                    <div class="inner text-dark">
                                        <h3>Transfer</h3>

                                        <p>Transfer Material</p>
                                    </div>
                                    <div class="icon">
                                        <svg width="50" height="50" viewBox="0 0 75 61" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M40.0769 43.75L52.9615 30.5L40.0769 17.25M4 30.5H50.3846"
                                                stroke="white" stroke-width="8" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M24.6154 17.25V10.625C24.6154 8.86794 25.2941 7.18285 26.5023 5.94042C27.7104 4.69799 29.3491 4 31.0577 4H64.5577C66.2663 4 67.9049 4.69799 69.1131 5.94042C70.3212 7.18285 71 8.86794 71 10.625V50.375C71 52.1321 70.3212 53.8172 69.1131 55.0596C67.9049 56.302 66.2663 57 64.5577 57H31.0577C29.3491 57 27.7104 56.302 26.5023 55.0596C25.2941 53.8172 24.6154 52.1321 24.6154 50.375V43.75"
                                                stroke="white" stroke-width="8" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-6 ">
                            <!-- box in -->
                            <a href="">
                                <div class="small-box">
                                    <div class="inner text-dark">
                                        <h3>Report</h3>

                                        <p>Laporan Pemakaian</p>
                                    </div>
                                    <div class="icon">
                                        <svg width="50" height="50" viewBox="0 0 63 67" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.25 21.7692V17.0769C17.25 13.3435 18.7513 9.76297 21.4237 7.12304C24.0961 4.4831 27.7207 3 31.5 3C35.2793 3 38.9039 4.4831 41.5763 7.12304C44.2487 9.76297 45.75 13.3435 45.75 17.0769V21.7692M5.375 21.7692C4.74511 21.7692 4.14102 22.0164 3.69562 22.4564C3.25022 22.8964 3 23.4931 3 24.1154V55.7885C3 60.2227 6.82375 64 11.3125 64H51.6875C56.1763 64 60 60.406 60 55.9718V24.1154C60 23.4931 59.7498 22.8964 59.3044 22.4564C58.859 22.0164 58.2549 21.7692 57.625 21.7692H5.375Z"
                                                stroke="white" stroke-width="6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M16.5001 30.1113V32.2899C16.5001 35.7567 18.0015 39.0814 20.6739 41.5328C23.3462 43.9842 26.9708 45.3613 30.7501 45.3613C34.5295 45.3613 38.154 43.9842 40.8264 41.5328C43.4988 39.0814 45.0001 35.7567 45.0001 32.2899V30.1113"
                                                stroke="white" stroke-width="6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
    </section>
    </div>
@endsection
