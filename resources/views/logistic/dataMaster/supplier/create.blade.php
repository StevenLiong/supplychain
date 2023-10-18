@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Form Tambah Data Supplier</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="{{ url('datamaster/supplier') }}" method="post">
                        @csrf
                        {{-- Form Tambah Data supplier --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="kd_supplier" class="form-label ">Kode Supplier</label>
                                    <input type="text"
                                        class="form-control @error('kd_supplier')
                                        is-invalid
                                    @enderror"
                                        id="kd_supplier" name="kd_supplier" placeholder="Kode supplier"
                                        value="{{ old('kd_supplier') }}">
                                    @error('kd_supplier')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                    <input type="text"
                                        class="form-control @error('nama_supplier') is-invalid
                                    @enderror"
                                        id="nama_supplier" name="nama_supplier" placeholder=" Nama supplier"
                                        value="{{ old('nama_supplier') }}">
                                    @error('nama_supplier')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text"
                                        class="form-control @error('email')
                                        is-invalid
                                    @enderror"
                                        id="email" name="email" placeholder="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="alamat" class="form-label">Alamat </label>
                                    <input type="text"
                                        class="form-control @error('alamat')
                                        is-invalid
                                    @enderror"
                                        id="alamat" name="alamat" placeholder="alamat" value="{{ old('alamat') }}">
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>
                <div class="m-3">
                    <button class="btn btn-red" type="submit" name="submit" id="submit">Submit</button>
                </div>
                </form>

            </div>
        </div>
        {{-- form end --}}
    </div>
    </div>
@endsection
