@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row col-lg-12 justify-content-center mt-3 ">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card p-3 rounded-0">
                        <div class="card-title text-center border-bottom">
                            <h3>List BOM {{ $item->nama_workcenter }}</h3>
                        </div>
                        <div class="card-body">
                            {{-- session success --}}
                            <div class="row px-2">
                                <div class="col-lg-12">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success rounded-0">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{-- session success end --}}

                            <div class="" style="height: 300px">
                                <table class="table table-bordered">
                                    <thead class=" text-center">
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode </th>
                                            <th>Nama Material</th>
                                            <th>Satuan</th>
                                            <th>Diserahkan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center  border-dark">
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $item->id_materialbom }}</td>
                                            <td>{{ $item->nama_materialbom }}</td>
                                            <td>{{ $item->uom_material }}</td>
                                            <td>{{ $item->usage_material }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row justify-content-center">
                                    <div class="btn-group">
                                        <div class="row">
                                            <a href="{{ url('/services/transaksiproduksi/listpending/cut/' . $item->nama_workcenter) }}"
                                                class="btn btn-xs btn-success" type="submit">Terima</a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
