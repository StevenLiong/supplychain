@extends('logistic.layouts.main')
@section('content')
    <div class="content-wrapper bg-white">
        <div class="container-fluid">
            {{-- headline --}}
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card mt-3 px-3 py-2 rounded-0" style="background: rgba(228, 45, 45, 0.70);">
                        <h4 class="text-bold m-0
                        ">SLIP PERMINTAAN MATERIAL</h4>
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
                                <td>SLIP PERMINTAAN MATERIAL</td>
                                <td>{{ $dataBom->nama_workcenter }}</td>
                            </tr>
                        </table>
                    </div>
                    {{-- tabel pertama end --}}
                    <div class="border border-dark mb-3">
                        {{-- table kedua --}}
                        <div class="info-bpnb">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>NO.W.O</th>
                                    <td>: PT. ABC</td>
                                    <th>Work Center</th>
                                    <td>: {{ $dataBom->nama_workcenter }}</td>
                                </tr>
                                <tr>
                                    <th>KVA</th>
                                    <td>: {{ $dataBom->kVA }}</td>
                                    <th>NO. BON</th>
                                    <td>: {{ $dataBom->no_bon }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>: - </td>
                                    <th>Tanggal</th>
                                    <td>: {{ $dataBom->tanggal_bon }}</td>
                                </tr>
                            </table>
                        </div>
                        {{-- table kedua end --}}

                        {{-- tabel-data --}}
                        <div class="tabel table-borderless border-dark" style="height: 300px">
                            <table class="table">
                                <thead class="border-top border-bottom border-dark text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode </th>
                                        <th>Nama Material</th>
                                        <th>Satuan</th>
                                        <th>Jumlah Diminta</th>
                                        <th>Diserahkan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center  border-dark">
                                    @foreach ($detailbom as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->id_materialbom }}</td>
                                            <td>{{ $item->nama_materialbom }}</td>
                                            <td>{{ $item->uom_material }}</td>
                                            <td>{{ $item->usage_material }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
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
