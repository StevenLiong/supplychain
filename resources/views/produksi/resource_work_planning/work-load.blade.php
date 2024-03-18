@extends('produksi.resource_work_planning.template.bar')
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-center">
                <div class="header-title">
                    <h4 class="card-title">Work Load</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center px-4">
                    <form action="{{ route('process.periodeWorkload') }}" method="post" id="periodeWorkloadForm">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-auto">
                                <label for="periodeWorkloadSelect">Pilih Periode:</label>
                            </div>
                            <div class="col-md-auto">
                                <select class="custom-select" name="periodeWorkload" id="periodeWorkloadSelect">
                                    <option value="1">Bulan Sekarang</option>
                                    <option value="2">Minggu sekarang</option>
                                    <option value="3">Minggu Depan</option>
                                    <option value="4">Bulan Depan</option>
                                </select>
                            </div>
                        </div>

                    </form>
                    {{-- <div class="ml-auto mr-3" style="align-items: d-flex right;">
                        <a href="#" class="btn btn-primary" data-target="#new-project-modal" data-toggle="modal"><i
                                class="mr-2 fa-solid fa-print"></i>Print</a>
                    </div> --}}
                </div>
                <div>
                    <div>
                        @foreach ($data['PL'] as $PL)
                            <table id="datatable_{{ $PL->nama_pl }}" class="table dataTable m-2" role="grid"
                                style="width:auto">
                                <thead class="text-center">
                                    <tr>
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $deadlineDate = $data['deadlineDate'];
                                                $qtyTrafo = $data['mps']
                                                    ->where('kva', $kap->ukuran_kapasitas)
                                                    ->where('production_line', $PL->nama_pl)
                                                    ->filter(function ($item) use ($deadlineDate) {
                                                        $deadline = \Carbon\Carbon::create(
                                                            $item['deadline']['year'],
                                                            $item['deadline']['month'],
                                                            $item['deadline']['day'],
                                                        );
                                                        return $deadline->between($deadlineDate[0], $deadlineDate[1]);
                                                    })
                                                    ->sum('qty_trafo');
                                            @endphp
                                        @endforeach
                                        <th colspan="{{ $kap->ukuran_kapasitas }}" class="bg-light">
                                            {{ $PL->nama_pl }}
                                            {{-- {{ $periodeLabel }} - {{ $PL->nama_pl }} --}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="text-left bg-light" style="width:8rem">
                                            Kva
                                        </th>
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $deadlineDate = $data['deadlineDate'];
                                                $qtyTrafo = $data['mps']
                                                    ->where('kva', $kap->ukuran_kapasitas)
                                                    ->where('production_line', $PL->nama_pl)
                                                    ->filter(function ($item) use ($deadlineDate) {
                                                        $deadline = \Carbon\Carbon::create(
                                                            $item['deadline']['year'],
                                                            $item['deadline']['month'],
                                                            $item['deadline']['day'],
                                                        );
                                                        return $deadline->between($deadlineDate[0], $deadlineDate[1]);
                                                    })
                                                    ->sum('qty_trafo');
                                            @endphp
                                            @if ($kap->ukuran_kapasitas && $qtyTrafo != 0)
                                                <th class="text-center">
                                                    {{ $kap->ukuran_kapasitas }}
                                                </th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <th class="text-left bg-light">Total pada {{ $PL->nama_pl }}</th>
                                        @foreach ($data['kapasitas'] as $kap)
                                            @php
                                                $deadlineDate = $data['deadlineDate'];
                                                $qtyTrafo = $data['mps']
                                                    ->where('kva', $kap->ukuran_kapasitas)
                                                    ->where('production_line', $PL->nama_pl)
                                                    ->filter(function ($item) use ($deadlineDate) {
                                                        $deadline = \Carbon\Carbon::create(
                                                            $item['deadline']['year'],
                                                            $item['deadline']['month'],
                                                            $item['deadline']['day'],
                                                        );
                                                        return $deadline->between($deadlineDate[0], $deadlineDate[1]);
                                                    })
                                                    ->sum('qty_trafo');
                                            @endphp
                                            @if ($kap->ukuran_kapasitas && $qtyTrafo != 0)
                                                <td class="text-center">
                                                    <span class="text-primary"
                                                        style="font-weight: bold;  background-color: #c7cbd3; padding: 5px; border-radius: 10px;">{{ $qtyTrafo }}</span>
                                                </td>
                                            @endif
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mendeteksi perubahan pada dropdown
            $('#periodeWorkloadSelect').change(function() {
                // Mengambil nilai yang dipilih
                var selectedValue = $(this).val();

                // Menyimpan nilai yang dipilih dalam localStorage
                localStorage.setItem('selectedPeriodeWorkload', selectedValue);

                // Mengirimkan formulir secara otomatis
                $('#periodeWorkloadForm').submit();
            });

            // Memeriksa apakah ada nilai yang disimpan dalam localStorage
            var storedValue = localStorage.getItem('selectedPeriodeWorkload');
            if (storedValue) {
                // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
                $('#periodeWorkloadSelect').val(storedValue);
            }
        });
    </script>
@endsection
