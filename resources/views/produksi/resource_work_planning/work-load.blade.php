@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Work Load</h4>
                </div>
            </div>
            <div class="card-body">

                <div class="row mb-4 align-items-center">
                    <div class="ml-auto mr-3" style="align-items: d-flex right;">
                        <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i
                                class="mr-2 fa-solid fa-print"></i>Print</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <div id="datatable_wrapper" class="dataTables_wrapper">
                        {{-- <table id="datatable" class="table data-table table-striped dataTable" role="grid"
                            aria-describedby="datatable_info">
                            <thead class="text-center ">
                                <tr>
                                    <th colspan="{{ count($data['kapasitas']) + 1 }}">
                                        1 Minggu
                                    </th>
                                </tr>
                                <tr>
                                    <th></th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        <th>
                                            @if ($kap->ukuran_kapasitas)
                                                {{ $kap->ukuran_kapasitas }}
                                            @endif
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($data['pl'] as $pl)
                                    <tr>
                                        <th>{{ $pl->nama_pl }}</th>
                                        @php
                                            $totalQtyTrafo = 0;
                                        @endphp
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $qtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->where('production_line', $pl->nama_pl)->sum('qty_trafo');

                                            @endphp
                                            <td>{{ $qtyTrafo }}</td>
                                        @endforeach

                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        @foreach ($data['pl'] as $pl)
                            <table id="datatable_{{ $pl->nama_pl }}" class="table table-striped dataTable m-2"
                                role="grid" aria-describedby="datatable_info">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="{{ count($data['kapasitas']) + 1 }}">
                                            {{ $periodeLabel }} - {{ $pl->nama_pl }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        @foreach ($data['kapasitas'] as $kap)
                                            <th>
                                                @if ($kap->ukuran_kapasitas)
                                                    {{ $kap->ukuran_kapasitas }}
                                                @endif
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <th>{{ $pl->nama_pl }}</th>
                                        @php
                                            $totalQtyTrafo = 0;
                                        @endphp
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $qtyTrafo = $data['mps']
                                                    ->where('kva', $kap->ukuran_kapasitas)
                                                    ->where('production_line', $pl->nama_pl)
                                                    ->where('deadline', '>=', $data['deadlineDate'])
                                                    ->sum('qty_trafo');
                                                // $totalQtyTrafo += $qtyTrafo;
                                            @endphp
                                            <td>{{ $qtyTrafo }}</td>
                                        @endforeach
                                        {{-- <td>{{ $totalQtyTrafo }}</td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach

                        {{-- <tbody class="text-center">
                                @foreach ($data['pl'] as $pl)
                                    <tr>
                                        <th>{{ $pl->nama_pl }}</th>
                                        @php
                                            $totalQtyTrafo = 0; // Inisialisasi totalQtyTrafo
                                        @endphp
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $qtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                                $totalQtyTrafo += $qtyTrafo; // Akumulasi totalQtyTrafo
                                            @endphp
                                            <td>{{ $qtyTrafo }}</td>
                                        @endforeach
                                        <td>{{ $totalQtyTrafo }}</td>
                                    </tr>
                                @endforeach
                            </tbody> --}}


                        {{-- <tr>
                                    <th>Coil HV</th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $totalQtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                        @endphp
                                        <td>{{ $totalQtyTrafo }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>CCA</th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $totalQtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                        @endphp
                                        <td>{{ $totalQtyTrafo }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Connect</th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $totalQtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                        @endphp
                                        <td>{{ $totalQtyTrafo }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Final Assembly</th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $totalQtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                        @endphp
                                        <td>{{ $totalQtyTrafo }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Finishing</th>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $totalQtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                        @endphp
                                        <td>{{ $totalQtyTrafo }}</td>
                                    @endforeach
                                </tr> --}}
                        {{-- <tr>
                                    <td>QC</td>
                                    @foreach ($data['kapasitas'] as $kap)
                                        @php
                                            $totalQtyTrafo = $data['mps']->where('kva', $kap->ukuran_kapasitas)->sum('qty_trafo');
                                        @endphp
                                        <td>{{ $totalQtyTrafo }}</td>
                                    @endforeach
                                </tr> --}}

                        {{-- </tbody> --}}

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
