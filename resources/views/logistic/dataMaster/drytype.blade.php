@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Data Master</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- table dry type --}}

            <div class="table-responsive px-3">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center text-lg">
                            <th colspan="6">Gudang Raw Material Dry Type</th>
                        </tr>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Qty</th>
                            <th>Satuan</th>
                            <th>Kode Rak</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>M0001</td>
                            <td>Alumunium Sheet</td>
                            <td>11,00</td>
                            <td>Kg</td>
                            <td>R0001</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- table dry type end --}}


            {{-- pagination --}}
            <div class="row ">
                <div class="col-12 p-3 ">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            {{-- pagination end --}}
        </div>
    </div>
@endsection
