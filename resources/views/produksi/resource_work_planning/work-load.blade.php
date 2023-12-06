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
                        @foreach ($data['PL'] as $PL)
                            <table id="datatable_{{ $PL->nama_pl }}" class="table table-striped dataTable m-2"
                                role="grid" aria-describedby="datatable_info">
                                <thead class="text-center">
                                    <tr>
                                        <th colspan="{{ count($data['kapasitas']) + 1 }}">
                                            {{ $periodeLabel }} - {{ $PL->nama_pl }}
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
                                        <th>{{ $PL->nama_pl }}</th>
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $qtyTrafo = $data['mps']
                                                    ->where('kva', $kap->ukuran_kapasitas)
                                                    ->where('production_line', $PL->nama_pl)
                                                    ->where('deadline', '>=', $data['deadlineDate'])
                                                    ->sum('qty_trafo');
                                            @endphp
                                            <td>
                                                @if ($qtyTrafo == 0)
                                                    {{ $qtyTrafo }}
                                                @else
                                                    <span
                                                        style="font-weight: bold; color: red; background-color: #d3d3d3; padding: 5px; border-radius: 10px;">{{ $qtyTrafo }}</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
