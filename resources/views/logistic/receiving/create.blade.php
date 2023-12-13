@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Input Kedatangan Material</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="{{ url('receiving/incoming') }}" method="post">
                        @csrf
                        <div class="table-responsive p-2">
                            <table class="table table-bordered ">
                                <tbody>
                                    {{-- material --}}
                                    <tr>
                                        <td class="border-form">
                                            <ul>
                                                <li>
                                                    <h3>Material</h3>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="kd_material_rak" class="form-label">Kode
                                                            Material</label>
                                                        <select
                                                            class="form-control form-select form-select-lg @error('kd_material_rak')
                                                            is-invalid
                                                        @enderror"
                                                            name="kd_material_rak" id="kd_material_rak"
                                                            onchange="updateMat(this)">
                                                            <option value="" selected>Pilih kode material</option>
                                                            @foreach ($materialRak as $item)
                                                                <option value="{{ $item->id }}"
                                                                    data-nama="{{ $item->material->nama_material }}"
                                                                    data-satuan="{{ $item->material->satuan }}"
                                                                    {{ old('kd_material_rak') == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->material->kd_material }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('kd_material_rak')
                                                            <span class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-2 p-2">
                                                        <label for="exampleInputName" class="form-label">Nama Material
                                                        </label>
                                                        <input type="text" class="form-control" id="materialname"
                                                            disabled name="materialname">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-2 p-2">
                                                        <label for="exampleInputSatuan" class="form-label">Satuan
                                                        </label>
                                                        <input type="text" class="form-control" id="satuan" disabled
                                                            name="satuan">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- form supplier --}}
                                    <tr>
                                        <td class="border-form">
                                            <ul>
                                                <li>
                                                    <h3>Supplier</h3>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="kd_supplier" class="form-label">Nama Supplier</label>
                                                        <select
                                                            class="form-control form-select form-select-lg @error('kd_supplier')
                                                            is-invalid
                                                        @enderror"
                                                            name="kd_supplier" id="kd_supplier" onchange="updateForm(this)">
                                                            <option value="" selected disabled>Pilih Kode Supplier
                                                            </option>
                                                            @foreach ($supplier as $item)
                                                                <option value="{{ $item->id }}"
                                                                    data-supplier="{{ $item->nama_supplier }}"
                                                                    data-valuta="{{ $item->valuta }}"
                                                                    {{ old('kd_supplier') == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->kd_supplier }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('kd_supplier')
                                                            <div class="invalid-feedback">
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <div class="col-mb-3">
                                                            <label for="exampleInputName" class="form-label">Nama Supplier
                                                            </label>
                                                            <input type="text" class="form-control" id="nama_supplier"
                                                                disabled name="nama_supplier">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <div class="col-mb-3">
                                                            <label for="exampleInputEmail" class="form-label">Valuta
                                                            </label>
                                                            <input type="text" class="form-control" id="valuta"
                                                                disabled name="valuta">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            {{-- form supplier end --}}
                                        </td>
                                    </tr>
                                    {{-- form informasi tambahan --}}
                                    <tr>
                                        <td class="border-form">
                                            <ul>
                                                <li>
                                                    <h3>Informasi Tambahan</h3>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="no_po" class="form-label"> No Purchase
                                                            Order</label>
                                                        <input type="text"
                                                            class="form-control @error('no_po')
                                                            is-invalid
                                                        @enderror"
                                                            id="no_po" name="no_po" placeholder="Input kode Purchase"
                                                            value="{{ old('no_po') }}">
                                                        @error('no_po')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3 p-2">
                                                        <label for="tgl_kedatangan" class="form-label">Tanggal
                                                            Kedatangan</label>
                                                        <input type="date"
                                                            class="form-control @error('tgl_kedatangan')
                                                            is-invalid
                                                        @enderror"
                                                            id="tgl_kedatangan" name="tgl_kedatangan"
                                                            placeholder="Input kode Purchase"
                                                            value="{{ old('tgl_kedatangan') }}">
                                                        @error('tgl_kedatangan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="no_surat_jalan" class="form-label">No Surat
                                                            jalan</label>
                                                        <input type="text"
                                                            class="form-control @error('no_surat_jalan')
                                                            is-invalid
                                                        @enderror"
                                                            id="no_surat_jalan" name="no_surat_jalan"
                                                            placeholder="Input kode Surat Jalan"
                                                            value="{{ old('no_surat_jalan') }}">
                                                        @error('no_surat_jalan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="batch_datang" class="form-label">Batch
                                                            Kedatangan</label>
                                                        <input type="text"
                                                            class="form-control @error('batch_datang')
                                                            is-invalid
                                                        @enderror"
                                                            id="batch_datang" name="batch_datang"
                                                            placeholder="Input Kode Batch Kedatangan"
                                                            value="{{ old('batch_datang') }}">
                                                        @error('batch_datang')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="qty_kedatangan" class="form-label">Qty
                                                            Kedatangan</label>
                                                        <input type="number"
                                                            class="form-control @error('qty_kedatangan')
                                                            is-invalid
                                                        @enderror"
                                                            id="qty_kedatangan" name="qty_kedatangan"
                                                            placeholder="Input Kode Batch Kedatangan"
                                                            value="{{ old('qty_kedatangan') }}">
                                                        @error('qty_kedatangan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- form informasi tambahan end --}}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
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


    <script>
        function updateForm(sel) {
            var selectedOption = $('#kd_supplier').find('option:selected');
            var suppliername = $('input[name="nama_supplier"]');
            var valuta = $('input[name="valuta"]');
            suppliername.val(selectedOption.data('supplier'));
            valuta.val(selectedOption.data('valuta'));
        }

        function updateMat(select) {
            var selectedOption = $('#kd_material_rak').find('option:selected');
            var materialname = $('input[name="materialname"]');
            var satuan = $('input[name="satuan"]');
            console.log(selectedOption.data('materialname'));

            materialname.val(selectedOption.data('nama'));
            satuan.val(selectedOption.data('satuan'));
        }
    </script>
@endsection
