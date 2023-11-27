@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Bukti Penerimaan Barang</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}

            {{-- form --}}
            <div class="row">
                <div class="col-12 px-3">
                    <form action="" method="post">
                        {{-- Bukti penerimaan barang --}}
                        <ul>
                            <li>
                                <h3>Bukti Penerimaan Barang</h3>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="kd_bpnb" class="form-label">Kode BPNB</label>
                                    <input type="text" class="form-control" id="kd_bpnb" name="kd_bpnb"
                                        placeholder=" Kode BPNB">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_po" class="form-label">Nomor PO</label>
                                    <input type="text" class="form-control" id="no_po" name="no_po"
                                        placeholder=" Nomor Purchase Order">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="no_surat_jalan" class="form-label">No Surat Jalan</label>
                                    <input type="text" class="form-control" id="no_surat_jalan" name="no_surat_jalan"
                                        placeholder=" Nomor Surat Jalan">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-3 p-2">
                                    <label for="tgl_surat_jalan" class="form-label">Tanggal Surat Jalan</label>
                                    <input type="date" class="form-control" id="tgl_surat_jalan" name="tgl_surat_jalan"
                                        placeholder="waktu kedatangan">
                                </div>
                            </div>
                            <div class="col-lg-3">
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
