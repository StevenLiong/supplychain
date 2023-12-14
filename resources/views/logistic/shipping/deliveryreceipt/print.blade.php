@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">Delivery List</h4>
                    </div>
                </div>
            </div>
            {{-- headline end --}}
        </div>
        {{-- tabel print --}}
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8">
                <div class="container">

                    {{-- button print --}}
                    <div class="btn-print mb-3">
                        <button class="btn btn-sm btn-red" id="print">Cetak</button>
                    </div>
                    {{-- button print end --}}
                    {{-- table pertama --}}
                    <div class="row">
                        <table class="table table-sm table-borderless text-bold">
                            <tr>
                                <td>PT Trafoindo Prima Perkasa</td>
                                <td>DELIVERY RECEIPT</td>
                                <td>22 DESEMBER 2002</td>
                            </tr>
                        </table>
                    </div>
                    {{-- tabel pertama end --}}
                    <div class="border border-dark mb-3">
                        {{-- table kedua --}}
                        <div class="info-bpnb">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>CUSTOMER</th>
                                    <td>: PT. ABC</td>
                                    <th>Issue Date</th>
                                    <td>: 31 Desember 2002</td>
                                </tr>
                                <tr>
                                    <th>DELIVERY SITE</th>
                                    <td>: Jl Siliwangi N0.41 Pamulang</td>
                                    {{-- <th>NO. BON</th>
                                    <td>: </td> --}}
                                </tr>
                                <tr>
                                    <th>S.O NO</th>
                                    <td>: So 001 </td>
                                    {{-- <th>Tanggal</th>
                                    <td>: </td> --}}
                                </tr>
                            </table>
                        </div>
                        {{-- table kedua end --}}

                        {{-- tabel-data --}}
                        <div class="tabel table-bordered " style="height: 300px">
                            <table class="table ">
                                <thead  class="border border-top border-bottom  border-dark text-center ">
                                    <tr >
                                        <th rowspan="2" class="text-center align-middle">ITEM NO.</th>
                                        <th rowspan="2" class="text-center align-middle">DESCRIPTION GOODS </th>
                                        <th rowspan="2" class="text-center align-middle">QTY</th>
                                        <th rowspan="2" class="text-center align-middle">CASE NO</th>
                                        <th colspan="2">NET WEIGHT</th>
                                        <th colspan="2">GROSS WEIGHT</th>
                                        <th colspan="2">MEASUREMENT</th>
                                        <th colspan="3">DIMENSION</th>
                                    </tr>
                                    <tr>
                                        <th>per Pkg</th>
                                        <th>Total</th>
                                        <th>per Pkg</th>
                                        <th>Total</th>
                                        <th>per Pkg</th>
                                        <th>Total</th>
                                        <th>(L)</th>
                                        <th>(W)</th>
                                        <th>(H)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center  border-dark">

                                </tbody>
                            </table>
                        </div>
                        <table class="table table-sm table-borderless">
                            <tr class="border-top border-dark">
                                <td>
                                    <p>Gudang</p>
                                    <p>MPPC</p>
                                    <p>Arsip</p>
                                </td>
                                <td class="text-center ">
                                    <p>Dibuat Oleh</p>
                                    <br>
                                    <br>
                                    <p>AMIN</p>
                                </td>
                                <td class="text-center">
                                    <p>DIserahkan Oleh,</p>
                                    <br>
                                </td>
                            </tr>
                        </table>
                        {{-- tabel footer end --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- tabel print end --}}
    </div>
    </div>
@endsection
