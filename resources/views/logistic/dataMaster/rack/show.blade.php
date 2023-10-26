@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row col-lg-12 justify-content-center mt-3 ">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card p-3 rounded-0">
                        <div class="card-title text-center border-bottom">
                            <h1>Detail Rak</h1>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode Rak</th>
                                    <td>: {{ $rak->kd_rak }}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Qty </th>
                                    <td>: {{ $rak->qty_rak}}</td>
                                </tr>
                                <tr>
                                    <th width="30%">Nama Material</th>
                                   
                                </tr>
                                <tr>
                                    <th width="30%">Kode Material</th>
                                    
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
