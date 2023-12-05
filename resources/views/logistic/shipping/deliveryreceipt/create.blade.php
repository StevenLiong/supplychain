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
                    <form action="{{ url('shipping/deliveryreceipt') }}" method="POST">
                        @csrf
                        {{-- Form Packing List --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="Tanggal_Delivery" class="form-label">Tanggal
                                        Delivery</label>
                                    <input type="date"
                                        class="form-control @error('Tanggal_Delivery')
                                        is-invalid
                                    @enderror"
                                        id="Tanggal_Delivery" name="Tanggal_Delivery"
                                        placeholder="Pilih Tanggal Delivery"
                                        value="{{ old('Tanggal_Delivery') }}">
                                    @error('Tanggal_Delivery')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="NO_SO" class="form-label">No. SO</label>
                                    <input type="text"
                                        class="form-control @error('NO_SO')
                                        is-invalid
                                    @enderror"
                                        id="NO_SO" name="NO_SO"
                                        placeholder="Input No. SO"
                                        value="{{ old('NO_SO') }}">
                                    @error('NO_SO')
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
                                        placeholder="Input WO"
                                        value="{{ old('NO_WO') }}">
                                    @error('NO_WO')
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