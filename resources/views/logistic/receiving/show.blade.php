@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row col-lg-12 justify-content-center mt-3 ">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card p-3 rounded-0">
                        <div class="card-title text-center border-bottom">
                            <h1>Detail barang</h1>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>No PO</th>
                                    <td>: {{ $incoming->no_po }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td>: {{ $incoming->material->nama_material }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <td>: {{ $incoming->supplier->nama_supplier }}</td>
                                </tr>
                                <tr>
                                    <th>Ending Stok</th>
                                    <td>: {{ $incoming->material->jumlah }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kedatangan</th>
                                    <td>: {{ $incoming->created_at }}</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
