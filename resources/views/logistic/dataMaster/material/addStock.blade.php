@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row col-lg-12 justify-content-center mt-3 ">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card p-3 rounded-0">
                        <div class="card-title text-center border-bottom">
                            <h1>Stock In</h1>
                        </div>
                        <div class="card-body">
                            {{-- session success --}}
                            <div class="row px-2">
                                <div class="col-lg-12">
                                    @if (session()->has('success'))
                                        {{-- <div class="alert alert-success rounded-0">
                                            {{ session('success') }}
                                        </div> --}}
                                    @endif
                                </div>
                            </div>
                            {{-- session success end --}}

                            <table class="table table-borderless">
                                <tr>
                                    <th>Kode Barang</th>
                                    <td>: {{ $material->kd_material }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td>: {{ $material->nama_material }}</td>
                                </tr>
                                <tr>
                                    <th>Ending Stok</th>
                                    <td>: {{ $material->jumlah }}</td>
                                </tr>
                            </table>
                            <div class="row justify-content-center">
                                <form action="{{ url('datamaster/material/addstock/' . $material->kd_material) }}" method="post"
                                    class="text-center">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="input-group my-2">
                                            <input type="number" class="form-control rounded-0" name="addstock"
                                                placeholder="Masukan Jumlah "
                                                aria-describedby="btn-addqty">
                                            <button class="btn btn-danger rounded-0" type="submit"
                                                id="btn-addqty">Tambah</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
