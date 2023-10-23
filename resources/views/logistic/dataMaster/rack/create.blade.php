@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Form Tambah Data Rak</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="{{ url('datamaster/rak') }}" method="post">
                        @csrf
                        {{-- Form Tambah Data Rak --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="kd_rak" class="form-label ">Kode rak</label>
                                    <input type="text"
                                        class="form-control @error('kd_rak')
                                        is-invalid
                                    @enderror"
                                        id="kd_rak" name="kd_rak" placeholder="Kode rak"
                                        value="{{ old('kd_rak') }}">
                                    @error('kd_rak')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="qty_rak" class="form-label">Qty</label>
                                    <input type="number"
                                        class="form-control @error('qty_rak')
                                        is-invalid
                                    @enderror"
                                        id="qty_rak" name="qty_rak" placeholder="qty_rak" value="{{ old('qty_rak') }}">
                                    @error('qty_rak')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </div>
                <div class="m-3">
                    <button class="btn btn-red" type="submit" >Submit</button>
                </div>
                </form>

            </div>
        </div>
        {{-- form end --}}
    </div>
    </div>
@endsection
