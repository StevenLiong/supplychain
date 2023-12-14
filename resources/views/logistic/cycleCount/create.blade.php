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
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <select name="satuan" id="satuan"
                                        class="form-control @error('satuan')
                                        is-invalid
                                    @enderror">
                                        <option value="">--</option>
                                        <option value="Set">Set</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Gram">Gram</option>
                                        <option value="Mililiter">Mililiter</option>
                                        <option value="Milimeter">Milimeter</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Lembaran">Lembaran</option>
                                        <option value="Liter">Liter</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Ton">Ton</option>
                                        <option value="Unit">Unit</option>
                                    </select>
                                    @error('satuan')
                                        <div class="invalid-feedback">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="jumlah" class="form-label">Jumlah </label>
                                    <input type="text"
                                        class="form-control @error('jumlah')
                                        is-invalid
                                    @enderror"
                                        id="jumlah" name="jumlah" placeholder="Jumlah" value="{{ old('jumlah') }}">
                                    @error('jumlah')
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
