@extends('planner.template.bar')
@section('content')
@section('kapasitas_produksi', 'active')
@section('main', 'show')
<div class="col-sm-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    Kapasitas Produksi
                </h4>
            </div>
        </div>
        <div class="row mb-4 align-items-center">
            <div class="dropdown status-dropdown ml-4 mt-4 dropdown-toggl" id="dropdownMenuButton03" data-toggle="dropdown" aria-expanded="false">
                <form action="{{ route('bulan.periode') }}" method="post" id="periodeForm">
                    @csrf
                    <label for="bulanPeriode">Pilih Bulan:</label>
                    <select class="custom-select " name="periode" id="bulanPeriode"><i class="ri-arrow-down-s-line ml-2 mr-0"></i>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="datatable_wrapper" class="dataTables_wrapper">
                    <table id="datatable" class="table data-table table-striped dataTable" role="grid" aria-describedby="datatable_info">
                        <thead>
                            <tr class=" justify-content-center" role="row">
                            <tr class="ligth sorting_asc" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 22px; text-align: center;" rowspan="2" class="text-center align-middle">Action</th>
                                <th style="width: 30px;text-align: center;" rowspan="2">No</th>
                                <th style="width: 30px; text-align: center" rowspan="2">Tanggal</th>
                                <th style="width: 18rem; text-align:center;" colspan="3" class="text-center align-middle">Kapasitas Produksi</th>
                            </tr>
                            <tr class="ligth" role="row" tabindex="0" aria-controls="datatable" aria-sort="ascending" aria-label="activate to sort column descending" style="width: auto;">
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">PL1 & Pl2</th>
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">PL3</th>
                                <th style="width: 6rem; text-align:center;" class="text-center align-middle">Dry Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataKapasitas as $index => $item)
                            <tr role="row" class="odd">
                                <td style="text-align: center;">
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <a href="{{ route('kp.editkp', $item->id) }}" class="btn btn-primary"><i class="fa-solid fa-edit"></i></a>
                                    </div>
                                </td>
                                <td style="width: 1rem;text-align: center;" class="sorting_1">{{ $index + 1 }}</td>
                                <td style="width: 6rem; text-align: center">{{ $item->tanggal }}</td>
                                <td style="width: 6rem; text-align: center">{{ $item->PL2 }}</td>
                                <td style="width: 6rem; text-align: center">{{ $item->PL3 }}</td>
                                <td style="width: 6rem; text-align: center">{{ $item->Drytype }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Mendeteksi perubahan pada dropdown
        $('#bulanPeriode').change(function() {
            // Mengambil nilai yang dipilih
            var selectedValue = $(this).val();

            // Menyimpan nilai yang dipilih dalam localStorage
            localStorage.setItem('selectedPeriode', selectedValue);

            // Mengirimkan formulir secara otomatis
            $('#periodeForm').submit();
        });

        // Memeriksa apakah ada nilai yang disimpan dalam localStorage
        var storedValue = localStorage.getItem('selectedPeriode');
        if (storedValue) {
            // Menetapkan nilai yang disimpan sebagai nilai awal dropdown
            $('#bulanPeriode').val(storedValue);
        }
    });
</script>

@endsection