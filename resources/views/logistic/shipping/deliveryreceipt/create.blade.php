@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Create Delivery Receipt </h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="{{ url('shipping/deliveryreceipt/create') }}" method="post">
                        @csrf
                        {{-- Form Packing List --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="tgl_pengiriman" class="form-label">Tanggal
                                        Pengiriman</label>
                                    <input type="date"
                                        class="form-control @error('tgl_pengiriman')
                                        is-invalid
                                    @enderror"
                                        id="tgl_pengiriman" name="tgl_pengiriman" placeholder="Input kode Purchase"
                                        value="{{ old('tgl_pengiriman') }}">
                                    @error('tgl_pengiriman')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_so" class="form-label">No. SO</label>
                                    <input type="text"
                                        class="form-control @error('no_so')
                                        is-invalid
                                    @enderror"
                                        id="no_so" name="no_so" placeholder="Input No. SO"
                                        value="{{ old('no_so') }}">
                                    @error('no_so')
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
                                        id="no_do" name="no_do" placeholder="Input No. DO"
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
                                    <label for="tgl_packing" class="form-label">Tanggal
                                        Packing</label>
                                    <input type="date"
                                        class="form-control @error('tgl_packing')
                                        is-invalid
                                    @enderror"
                                        id="tgl_packing" name="tgl_packing" placeholder="Input kode Purchase"
                                        value="{{ old('tgl_packing') }}">
                                    @error('tgl_packing')
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
