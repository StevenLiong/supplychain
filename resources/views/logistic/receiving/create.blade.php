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
                    <form action="{{ url('/receiving/incoming/store') }}" method="post">
                        @csrf
                        <div class="table-responsive p-2">
                            <table class="table table-bordered ">
                                <tbody>
                                    <tr>
                                        <td class="border-form">
                                            {{-- material --}}
                                            <ul>
                                                <li>
                                                    <h3>Material</h3>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="kd_material" class="form-label">Kode Material</label>
                                                        <select class="form-control form-select form-select-lg "
                                                            name="kd_material" id="kd_material">
                                                            <option selected>Pilih kode material</option>
                                                            @foreach ($material as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->kd_material }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-form">
                                            {{-- form supplier --}}
                                            <ul>
                                                <li>
                                                    <h3>Supplier</h3>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="kd_supplier" class="form-label">Kode Material</label>
                                                        <select class="form-control form-select form-select-lg @error('kd_supplier')
                                                            is-invalid
                                                        @enderror"
                                                            name="kd_supplier" id="kd_supplier">
                                                            <option selected>Pilih kode Supplier</option>
                                                            @foreach ($supplier as $item)
                                                            <option value="{{ $item->id }}">{{ $item->nama_supplier }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('kd_supplier')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- form supplier end --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-form">
                                            {{-- form informasi tambahab --}}
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
                                                        <input type="text" class="form-control @error('no_po')
                                                            is-invalid
                                                        @enderror" id="no_po"
                                                            name="no_po" placeholder="Input kode Purchase">
                                                            @error('no_po')
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
                                                        <input type="text" class="form-control @error('no_surat_jalan')
                                                            is-invalid
                                                        @enderror" id="no_surat_jalan"
                                                            name="no_surat_jalan" placeholder="Input kode Surat Jalan">
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
                                                        <input type="text" class="form-control @error('batch_datang')
                                                            is-invalid
                                                        @enderror" id="batch_datang"
                                                            name="batch_datang" placeholder="Input Kode Batch Kedatangan">
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
                                                        <input type="text" class="form-control @error('qty_kedatangan')
                                                            is-invalid
                                                        @enderror" id="qty_kedatangan"
                                                            name="qty_kedatangan"
                                                            placeholder="Input Kode Batch Kedatangan">
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
@endsection

<script>
    document.getElementById('kd_material').addEventListener('change', function() {
        var select = this;
        var selectedOption = select.options[select.selectedIndex];
        var namaMaterial = selectedOption.getAttribute('data-nama');
        var satuan = selectedOption.getAttribute('data-satuan');
        var qty = selectedOption.getAttribute('data-qty');

        document.getElementById('nama_material').value = namaMaterial;
        document.getElementById('satuan').value = satuan;
        document.getElementById('qty').value = qty;
    });
</script>
