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
        </div>
        {{-- tabel print --}}
        <div class="row px-3">
            <div class="col-lg-12 col-md-12">
                <div class="container">
                    <div class="bnpb-container border border-dark mb-3">
                        {{-- table pertama --}}
                        <div class="row ">
                            <div class="col-lg-4 ">
                                <div class="">
                                    <td>PT TRAFOINDO</td>
                                </div>
                            </div>
                            <div class="col-lg-4 gap-0">
                                 <div class="text-center">
                                    <p class="">BUKTI PENERIMAAN BARANG</p>
                                </div>
                            </div>
                            <div class="col-lg-4 gap-0">
                                <div class="">
                                    <table>
                                        <tr>
                                            <td>No Surat Jalan</td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. Surat Jalan</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- tabel pertama end --}}
    
                        {{-- table kedua --}}
                        <div class="info-bpnb border border-dark">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama</th>
                                    <td>: PT. ABC</td>
                                    <th>No. Surat PO</th>
                                    <td>: 123456</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: Jl. Jendral Sudirman No. 123, Jakarta</td>
                                    <th>Tgl Surat jalan</th>
                                    <td>: 12/20/20</td>
                                </tr>
                                <tr>
                                    <th>No. Surat Jalan</th>
                                    <td>: SJ0990281</td>
                                    <th>Jenis Pembelian</th>
                                    <td>: Pembelian Lokal</td>
                                </tr>
                            </table>
                        </div>
                        {{-- table kedua end --}}
    
                        {{-- tabel-data --}}
                        <div class="tabel border border-dark" style="height: 300px">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama dan Kode Material</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                    <th>No. MR</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Tembaga 52418</td>
                                    <td>100</td>
                                    <td>Kg</td>
                                    <td>1P0838640</td>
                                </tr>
                            </table>
                        </div>
                        {{-- tabel data end --}}

                        {{-- tabel footer --}}
                        <div class="row px-2">
                            <div class="col-lg-4">
                                <p>Lampiran Kas</p>
                                <p>Gudang</p>
                                <p>purchasing</p>
                            </div>
                            <div class="col-lg-4">
                                    <p>Bagian Gudang</p>
                                    <p>Yati</p>
                            </div>
                            <div class="col-lg-4">
                                    <p>Mengetahui, Ka Dept. Gudang</p>
                                    <p>Arismanto </p>
                            </div>
                        </div>
                        {{-- tabel footer end --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- tabel print end --}}
    </div>
    </div>
@endsection
