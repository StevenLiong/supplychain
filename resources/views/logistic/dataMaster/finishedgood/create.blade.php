@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Form Stok Finished Good </h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            <div class="card mx-2 p-2">
                {{-- form --}}
                <div class="row">
                    <div class="col-12 px-3">
                        <form action="{{ url('datamaster/finishedgood') }}" method="post">
                            @csrf
                            {{-- Form Tambah Data finieshd good --}}
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="id_wo" class="form-label">Referensi (WO)</label>
                                        <select name="id_wo" id="id_wo" onchange="dataWo(this)"
                                            class="form-control @error('id_wo')
                                            is-invalid
                                        @enderror">
                                            <option>Pilih No Work Order</option>
                                            @foreach ($wo as $item)
                                                <option value="{{ $item->id_wo }}" data-fg="{{ $item->id_fg }}"
                                                    data-qty="{{ $item->qty_trafo }}" data-kva="{{ $item->kva }}">
                                                    {{ $item->id_wo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_wo')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <div class="col-mb-3">
                                            <label for="exampleInputName" class="form-label">Kode Finished Good
                                            </label>
                                            <input type="text" class="form-control" id="kd_finishedgood" readonly
                                                name="kd_finishedgood">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <div class="col-mb-3">
                                            <label for="exampleInputName" class="form-label">Qty
                                            </label>
                                            <input type="text" class="form-control" id="qty_trafo" readonly
                                                name="qty_trafo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <div class="col-mb-3">
                                            <label for="exampleInputName" class="form-label">kVA
                                            </label>
                                            <input type="text" class="form-control" id="kva" readonly
                                                name="kva">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="nsp" class="form-label ">NSP</label>
                                        <input type="input"
                                            class="form-control @error('nsp')
                                            is-invalid
                                        @enderror"
                                            id="nsp" name="nsp" placeholder="nsp" value="{{ old('nsp') }}">
                                        @error('nsp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="nsk" class="form-label ">NSK</label>
                                        <input type="input"
                                            class="form-control @error('nsk')
                                            is-invalid
                                        @enderror"
                                            id="nsk" name="nsk" placeholder="nsk" value="{{ old('nsk') }}">
                                        @error('nsk')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-3 p-2">
                                        <label for="gudang" class="form-label">Gudang</label>
                                        <select name="gudang" id="gudang" onchange="dataWo(this)"
                                            class="form-control @error('gudang')
                                            is-invalid
                                        @enderror">
                                            <option>Pilih Gudang</option>
                                            @foreach ($gudang as $item)
                                                <option value="{{ $item->nama_gudang }}">
                                                    {{ $item->nama_gudang }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('gudang')
                                            <div class="invalid-feedback">
                                                <p>{{ $message }}</p>
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
                {{-- form end --}}
            </div>

        </div>
    </div>
    </div>

    <script>
        function dataWo(sel) {
            var selectedOption = $('#id_wo').find('option:selected');
            var kdFg = $('#kd_finishedgood');
            var qty = $('#qty_trafo');
            var kva = $('#kva');
            kdFg.val(selectedOption.data('fg'));
            qty.val(selectedOption.data('qty'));
            kva.val(selectedOption.data('kva'));
        }
    </script>
@endsection
