@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0">Delivery Receipt</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}
        </div>
        {{-- tabel print --}}
        <div class="row px-3 justify-content-center">
            <div class="col-lg-10 col-md-10">
                <div class="container">
                    <div class="bnpb-container border border-dark mb-3">
                        {{-- table pertama --}}
                        <div class="row">
                            <div class="col-lg-4 text-left"> {{-- Adjusted to "text-left" --}}
                                <div>
                                    <h6 class="text-bold m-0"> PT. Trafoindo Prima Perkasa</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 gap-0 ">
                                <div class="text-center">
                                    <h5 class="text-bold m-0">Delivery Receipt</h5>
                                </div>
                            </div>
                            <div class="col-lg-4 text-right"> {{-- Adjusted to "text-right" --}}
                                <div>                                   
                                    <tr>
                                        <td>Issue Date : </td>
                                        <th>12 Desember 2023  </th>
                                    </tr>
                                        {{-- <tr>
                                            <td>Tgl. Surat Jalan</td>
                                        </tr> --}}                                    
                                </div>
                            </div>
                        </div>
                        {{-- tabel pertama end --}}

                        {{-- table kedua --}}
                        <div class="info-bpnb border border-dark">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Customer</th>
                                    <td>: Ravika Factory</td>
                                </tr>
                                <tr>
                                    <th>Delivery Site</th>
                                    <td>: Jl. Jendral Sudirman No. 123, Jakarta</td>
                                </tr>
                                <tr>
                                    <th>No. SO</th>
                                    <td>: SJ0990281</td>
                                </tr>
                            </table>
                        </div>
                        {{-- table kedua end --}}

                        {{-- tabel-data --}}
                        <div class="tabel border border-dark" style="height: 300px">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Item No.</th>
                                    <th>Description of Goods</th>
                                    <th>Qty</th>
                                    <th>Case No.</th>
                                    <th>Net Weight</th>
                                    <th>Per KG</th>
                                    <th>Total</th>
                                    <th>Gross Weight</th>
                                    <th>Per KG</th>
                                    <th>Total</th>
                                    <th>Measurement</th>
                                    <th>Per KG</th>
                                    <th>Total</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Tembaga 52418</td>
                                    <td>100</td>
                                    <td>1P0838640</td>
                                    <td>500</td>
                                    <td>5</td>
                                    <td>2500</td>
                                    <td>700</td>
                                    <td>7</td>
                                    <td>3500</td>
                                    <td>10</td>
                                    <td>1</td>
                                    <td>10</td>
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