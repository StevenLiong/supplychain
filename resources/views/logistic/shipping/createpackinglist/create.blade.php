@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Create Packing List </h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="{{ url('shipping/createpackinglist/create') }}" method="post">
                        @csrf
                        {{-- Form Packing List --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="tgl_packing" class="form-label">Tanggal
                                        Packing</label>
                                    <input type="date"
                                        class="form-control @error('tgl_packing')
                                        is-invalid
                                    @enderror"
                                        id="tgl_packing" name="tgl_packing"
                                        placeholder="Input kode Purchase"
                                        value="{{ old('tgl_packing') }}">
                                    @error('tgl_packing')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_do" class="form-label">No. DO</label>
                                    <input type="text"
                                        class="form-control @error('no_do')
                                        is-invalid
                                    @enderror"
                                        id="no_do" name="no_do"
                                        placeholder="Input No. DO"
                                        value="{{ old('no_do') }}">
                                    @error('no_do')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_wo" class="form-label">No. WO</label>
                                    <input type="text"
                                        class="form-control @error('no_wo')
                                        is-invalid
                                    @enderror"
                                        id="no_wo" name="no_wo"
                                        placeholder="Input No. WO"
                                        value="{{ old('no_wo') }}">
                                    @error('no_wo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="nsp" class="form-label">NSP</label>
                                    <input type="text"
                                        class="form-control @error('nsp')
                                        is-invalid
                                    @enderror"
                                        id="nsp" name="nsp"
                                        placeholder="Input NSP"
                                        value="{{ old('nsp') }}">
                                    @error('nsp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="nsk" class="form-label">NSK</label>
                                    <input type="text"
                                        class="form-control @error('nsk')
                                        is-invalid
                                    @enderror"
                                        id="nsk" name="nsk"
                                        placeholder="Input NSK"
                                        value="{{ old('nsk') }}">
                                    @error('nsk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="packaging" class="form-label">Packaging</label>
                                    <input type="text"
                                        class="form-control @error('packaging')
                                        is-invalid
                                    @enderror"
                                        id="packaging" name="packaging"
                                        placeholder="Input Packaging"
                                        value="{{ old('packaging') }}">
                                    @error('packaging')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="ukuran_dimensi" class="form-label">Ukuran & Dismensi</label>
                                    <input type="text"
                                        class="form-control @error('ukuran_dimensi')
                                        is-invalid
                                    @enderror"
                                        id="ukuran_dimensi" name="ukuran_dimensi"
                                        placeholder="Input Ukuran & Dimensi"
                                        value="{{ old('ukuran_dimensi') }}">
                                    @error('ukuran_dimensi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="customer" class="form-label">Customer</label>
                                    <input type="text"
                                        class="form-control @error('customer')
                                        is-invalid
                                    @enderror"
                                        id="customer" name="customer"
                                        placeholder="Input Supplier"
                                        value="{{ old('customer') }}">
                                    @error('customer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="m-3">
                            <button class="btn btn-red" type="submit" id="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- form end --}}

        </div>
    </div>
@endsection