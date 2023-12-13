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
                    <form action="{{ url('shipping/createpackinglist') }}" method="POST">
                        @csrf
                        {{-- Form Packing List --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="Tanggal_Packing" class="form-label">Tanggal
                                        Packing</label>
                                    <input type="date"
                                        class="form-control @error('Tanggal_Packing')
                                        is-invalid
                                    @enderror"
                                        id="Tanggal_Packing" name="Tanggal_Packing"
                                        placeholder="Pilih Tanggal Packing"
                                        value="{{ old('Tanggal_Packing') }}">
                                    @error('Tanggal_Packing')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="NO_DO" class="form-label">No. DO</label>
                                    <input type="text"
                                        class="form-control @error('NO_DO')
                                        is-invalid
                                    @enderror"
                                        id="NO_DO" name="NO_DO"
                                        placeholder="Input No. DO"
                                        value="{{ old('NO_DO') }}">
                                    @error('NO_DO')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="NO_WO" class="form-label">No. WO</label>
                                    <input type="text"
                                        class="form-control @error('NO_WO')
                                        is-invalid
                                    @enderror"
                                        id="NO_WO" name="NO_WO"
                                        placeholder="Input No. WO"
                                        value="{{ old('NO_WO') }}">
                                    @error('NO_WO')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="NSP" class="form-label">NSP</label>
                                    <input type="text"
                                        class="form-control @error('NSP')
                                        is-invalid
                                    @enderror"
                                        id="NSP" name="NSP"
                                        placeholder="Input NSP"
                                        value="{{ old('NSP') }}">
                                    @error('NSP')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="NSK" class="form-label">NSK</label>
                                    <input type="text"
                                        class="form-control @error('NSK')
                                        is-invalid
                                    @enderror"
                                        id="NSK" name="NSK"
                                        placeholder="Input NSK"
                                        value="{{ old('NSK') }}">
                                    @error('NSK')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="packaging" class="form-label">Packaging</label>
                                    <select class="form-control @error('packaging') is-invalid @enderror" id="packaging" name="packaging">
                                        <option value="" selected disabled>Choose Packaging</option>
                                        <option value="plastik" {{ old('packaging') == 'plastik' ? 'selected' : '' }}>Plastik</option>
                                        <option value="peti" {{ old('packaging') == 'peti' ? 'selected' : '' }}>Peti</option>
                                        <option value="pallet" {{ old('packaging') == 'pallet' ? 'selected' : '' }}>Pallet</option>
                                    </select>
                                    @error('packaging')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="ukuran_dimensi" class="form-label">Ukuran & Dimensi</label>
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
                                        placeholder="Input Customer"
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