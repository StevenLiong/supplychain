@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Form Tambah Data Material</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="" method="post">
                        {{-- Form Tambah Data Material --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="kd_material" class="form-label">Kode Material</label>
                                    <input type="text" class="form-control" id="kd_material" name="kd_material"
                                        placeholder="Spesifikasi tambahan">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="nama_material" class="form-label">Nama Material</label>
                                    <input type="text" class="form-control" id="nama_material" name="nama_material"
                                        placeholder=" Nama Material">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="spesifikasi_material" class="form-label">Spesifikasi Material</label>
                                    <input type="text" class="form-control" id="spesifikasi_material"
                                        name="spesifikasi_material" placeholder="waktu kedatangan">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="spesifikasi" class="form-label">Spesifikasi</label>
                                    <input type="text" class="form-control" id="spesifikasi" name="spesifikasi"
                                        placeholder="Spesifikasi Material">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="satuan" class="form-label">Satuan </label>
                                    <input type="text" class="form-control" id="satuan" name="satuan"
                                        placeholder="Satuan">
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="jumlah" class="form-label">Jumlah </label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah"
                                        placeholder="Jumlah">
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
