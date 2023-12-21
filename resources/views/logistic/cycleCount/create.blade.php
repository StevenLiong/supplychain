@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Create Cycle Count</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            <div class="card mx-2 p-2">
                {{-- form --}}
                <div class="row">
                    <div class="col-12 px-3">
                        <form action="{{ url('datamaster') }}" method="post">
                            @csrf
                            {{-- Form Tambah CycleCount --}}
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="kd_material" class="form-label ">Kode Material</label>
                                        <input type="text"
                                            class="form-control @error('kd_material')
                                        is-invalid
                                    @enderror"
                                            id="kd_material" name="kd_material" placeholder="Kode material"
                                            value="{{ old('kd_material') }}">
                                        @error('kd_material')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="nama_material" class="form-label">Nama Material</label>
                                        <input type="text"
                                            class="form-control @error('nama_material') is-invalid
                                    @enderror"
                                            id="nama_material" name="nama_material" placeholder=" Nama Material"
                                            value="{{ old('nama_material') }}">
                                        @error('nama_material')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="kd_rak" class="form-label">Kode Rak</label>
                                        <input type="text" class="form-control">
                                        @error('kd_rak')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="gudang" class="form-label">Gudang </label>
                                        <input type="text"
                                            class="form-control @error('gudang')
                                        is-invalid
                                    @enderror"
                                            id="gudang" name="gudang" placeholder="gudang" value="{{ old('gudang') }}">
                                        @error('gudang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="tgl_mulai" class="form-label">Tanggal Mulai </label>
                                        <input type="text"
                                            class="form-control @error('tgl_mulai')
                                        is-invalid
                                    @enderror"
                                            id="tgl_mulai" name="tgl_mulai" placeholder="tgl_mulai"
                                            value="{{ old('tgl_mulai') }}">
                                        @error('tgl_mulai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="tgl_selesai" class="form-label">Tanggal Selesai </label>
                                        <input type="text"
                                            class="form-control @error('tgl_selesai')
                                        is-invalid
                                    @enderror"
                                            id="tgl_selesai" name="tgl_selesai" placeholder="tgl_selesai"
                                            value="{{ old('tgl_selesai') }}">
                                        @error('tgl_selesai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="nama_oerator" class="form-label">Nama Operator </label>
                                        <input type="text"
                                            class="form-control @error('nama_oerator')
                                        is-invalid
                                    @enderror"
                                            id="nama_oerator" name="nama_oerator" placeholder="nama_oerator"
                                            value="{{ old('nama_oerator') }}">
                                        @error('nama_oerator')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="percentage" class="form-label">Percentage</label>
                                        <input type="text"
                                            class="form-control @error('percentage')
                                        is-invalid
                                    @enderror"
                                            id="percentage" name="percentage" placeholder="percentage"
                                            value="{{ old('percentage') }}">
                                        @error('percentage')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="count_qty" class="form-label">Count Quantity</label>
                                        <input type="text"
                                            class="form-control @error('count_qty')
                                        is-invalid
                                    @enderror"
                                            id="count_qty" name="count_qty" placeholder="count_qty"
                                            value="{{ old('count_qty') }}">
                                        @error('count_qty')
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
        </div>
        {{-- form end --}}
    </div>
    </div>
@endsection
