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
                    <form action="" method="post">
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
                                                        <select class="form-control form-select form-select-lg"
                                                            name="kd_material" id="kd_material">
                                                            <option selected>Pilih kode material</option>
                                                            <option value="M1000">M1000</option>
                                                            <option value="M1000">M0002</option>
                                                            <option value="M1000">M0003</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 p-2">
                                                        <label for="spek_tambahan" class="form-label">Spesifikasi
                                                            Tambahan</label>
                                                        <input type="text" class="form-control" id="spek_tambahan"
                                                            name="spek_tambahan" placeholder="Spesifikasi tambahan">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="nama_material" class="form-label">Nama Material</label>
                                                        <input type="text" class="form-control" id="nama_material"
                                                            name="nama_material" placeholder=" Nama Material">
                                                    </div>
                                                    <div class="mb-3 p-2">
                                                        <label for="kd_rak" class="form-label">Kode Rak</label>
                                                        <input type="text" class="form-control" id="kd_rak"
                                                            name="kd_rak" placeholder="kode rak">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="wkt_kedatangan" class="form-label">Waktu
                                                            Kedatangan</label>
                                                        <input type="text" class="form-control" id="wkt_kedatangan"
                                                            name="wkt_kedatangan" placeholder="waktu kedatangan">
                                                    </div>
                                                    <div class="mb-3 p-2">
                                                        <label for="nama_gudang" class="form-label">Nama Gudang</label>
                                                        <input type="text" class="form-control" id="nama_gudang"
                                                            name="nama_gudang" placeholder="Nama Gudang">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                                        <input type="text" class="form-control" id="spesifikasi"
                                                            name="spesifikasi" placeholder="Spesifikasi Material">
                                                    </div>
                                                    <div class="mb-3 p-2">
                                                        <label for="jenis_material" class="form-label">Jenis
                                                            Material</label>
                                                        <input type="text" class="form-control" id="jenis_material"
                                                            name="jenis_material" placeholder="jenis Material">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-form">
                                            {{-- form purchase order --}}
                                            <ul>
                                                <li>
                                                    <h3>Purchase Order</h3>
                                                </li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="purchase_order" class="form-label">Purchase
                                                            Order</label>
                                                        <input type="text" class="form-control" id="purchase_order"
                                                            name="purchase_order" placeholder="Input kode Purchase">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="surat_jalan" class="form-label">Surat
                                                            surat_jalan</label>
                                                        <input type="text" class="form-control" id="surat_jalan"
                                                            name="surat_jalan" placeholder="Input kode Surat Jalan">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="batch_datang" class="form-label">Alamat
                                                            Supplier</label>
                                                        <input type="text" class="form-control" id="batch_datang"
                                                            name="batch_datang" placeholder="Input Kode Batch Kedatangan">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- form purchse order end --}}
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
                                                        <select class="form-control form-select form-select-lg"
                                                            name="kd_supplier" id="kd_supplier">
                                                            <option selected>Pilih kode Supplier</option>
                                                            <option value="M1000">M1000</option>
                                                            <option value="M1000">M0002</option>
                                                            <option value="M1000">M0003</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="nama_supplier" class="form-label">Nama
                                                            Supplier</label>
                                                        <input type="text" class="form-control" id="nama_supplier"
                                                            name="nama_supplier" placeholder="Nama Supplier">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3 p-2">
                                                        <label for="alamat_supplier" class="form-label">Alamat
                                                            Supplier</label>
                                                        <input type="text" class="form-control" id="alamat_supplier"
                                                            name="alamat_supplier" placeholder="Alamat Supplier">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- form supplier end --}}
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
