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
                    <form action="{{ url('storage/rawmaterial/listmaterial') }}" method="post">
                        @csrf
                        {{-- Form Packing List --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="material_id" class="form-label ">Kode Material</label>
                                    <select name="material_id" id="material_id"
                                        class="form-control @error('material_id')
                                            is-invalid
                                        @enderror">
                                        <option value="">Pilih kode Material</option>
                                        @foreach ($material as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('material_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->kd_material }}</option>
                                        @endforeach
                                    </select>
                                    @error('material_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="rak_id" class="form-label">Kode Rak</label>
                                    <select name="rak_id" id="rak_id"
                                        class="form-control @error('rak_id')
                                        is-invalid
                                    @enderror">
                                        <option value="">Masukan Kode Rak</option>
                                        @foreach ($rak as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('rak_id') == $item->id ? 'selected' : '' }}>{{ $item->kd_rak }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rak_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="qty_rak" class="form-label">Qty Rak</label>
                                    <input type="number"
                                        class="form-control @error('qty_rak')
                                        is-invalid
                                    @enderror"
                                        name="qty_rak" id="qty_rak" value="{{ old('qty_rak') }}">
                                    @error('qty_rak')
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