@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0">Put Raw Material Away</h4>
                    </div>
                </div>
            </div>

            {{-- Informasi Rack --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="" method="post">

                        <ul>
                            <li>
                                <h5>Informasi Rack</h5>
                            </li>
                        </ul>

                        {{-- table --}}
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Rack</th>
                                        <th>Nama Material</th>
                                        <th>Qty Rack</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>M1000</td>
                                        <td>Besi</td>
                                        <td>100</td>
                                        <td>Kg</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>M0002</td>
                                        <td>Kayu</td>
                                        <td>200</td>
                                        <td>Buah</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>M0003</td>
                                        <td>Plastik</td>
                                        <td>300</td>
                                        <td>Unit</td>
                                    </tr>
                                </tbody>
                            </table>
                    </form>
                </div>
            </div>

            {{-- tambah material --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="" method="post">

                        <ul>
                            <li>
                                <h5>Tambah Material</h5>
                            </li>
                        </ul>

                        {{-- Form Tambah Material --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="kd_material" class="form-label">Kode Material</label>
                                    <select class="form-control form-select form-select-lg" name="kd_material"
                                        id="kd_material" required>
                                        <option selected>Pilih kode material</option>
                                        <option value="M1000">M1000</option>
                                        <option value="M0002">M0002</option>
                                        <option value="M0003">M0003</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="nama_material" class="form-label">Nama Material</label>
                                    <input type="text" class="form-control" id="nama_material" name="nama_material"
                                        placeholder="Nama Material" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="qty_material" class="form-label">Qty Material</label>
                                    <input type="number" class="form-control" id="qty_material" name="qty_material"
                                        placeholder="Qty Material" required>
                                </div>
                            </div>
                            <div class="col-lg-3">    
                                <div class="mb-3 p-2">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="number" class="form-control" id="satuan" name="satuan"
                                        placeholder="Satuan" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="qty_rack" class="form-label">Qty Rack</label>
                                    <input type="number" class="form-control" id="qty_rack" name="qty_rack"
                                        placeholder="Qty Rack" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="nama_gudang" class="form-label">Nama Gudang</label>
                                    <input type="text" class="form-control" id="nama_gudang" name="nama_gudang"
                                        placeholder="Nama Gudang" required>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="m-3" style="text-align: center;">
                            <button class="btn btn-red" type="submit" name="submit" id="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

