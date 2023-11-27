@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Form Order</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="{{ url('datamaster/material') }}" method="post">
                        @csrf
                        {{-- Form Tambah Data Material --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_bon" class="form-label ">No Bon</label>
                                    <input type="text"
                                        class="form-control @error('no_bon')
                                        is-invalid
                                    @enderror"
                                        id="no_bon" name="no_bon" placeholder="Kode material"
                                        value="{{ old('no_bon') }}">
                                    @error('no_bon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_wo" class="form-label">No .Wo</label>
                                    <select name="no_wo" id="no_wo"
                                        class="form-control @error('no_wo')
                                        is-invalid
                                    @enderror">
                                        <option value="">--</option>
                                    </select>
                                    @error('no_wo')
                                        <div class="invalid-feedback">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="keterangan" class="form-label ">Keterangan</label>
                                    <input type="text"
                                        class="form-control @error('keterangan')
                                        is-invalid
                                    @enderror"
                                        id="keterangan" name="keterangan" placeholder="Keteranga"
                                        value="{{ old('keterangan') }}">
                                    @error('keterangan')
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
