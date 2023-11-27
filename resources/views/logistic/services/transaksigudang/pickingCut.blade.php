@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            <div class="row col-lg-12 justify-content-center mt-3 ">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card p-3 rounded-0">
                        <div class="card-title text-center border-bottom">
                            <h1>Update Kuantitas Rak</h1>
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

                            <table class="table table-borderless">
                                <tr>
                                    <th>Kode Rak</th>
                                    <td>: {{ $materialRak->rak->kd_rak }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Material</th>
                                    <td>: {{ $materialRak->material->kd_material }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Material</th>
                                    <td>: {{ $materialRak->material->nama_material }}</td>
                                </tr>
                                <tr>
                                    <th>Ending Stok</th>
                                    <td>: {{ $materialRak->qty_rak }}</td>
                                </tr>
                            </table>
                            <div class="row justify-content-center">
                                <form action="{{ url('services/transaksigudang/picking/cutstock/' . $materialRak->id) }}" method="post"
                                    class="text-center">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="input-group my-2">
                                            <input type="number" class="form-control rounded-0" name="cutstock"
                                                placeholder="Masukan Jumlah "
                                                aria-describedby="btn-cutqty">
                                            <button class="btn btn-danger rounded-0" type="submit"
                                                id="btn-cutqty">Update</button>
                                        </div>
                                    </div>
                                    <p class="text-danger">Setelah klik update, kuantitas dalam rak ini akan terpotong !!!</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
