@extends('planner.template.layout')
@section('style')
<style>
    .content-page{
        margin: 0;
        padding: 0;
    }
    .table-wrapper {
        overflow-x: scroll;
        overflow-y: scroll;
        display: flex;
        height: fit-content;
    }
    .freeze-column{
        position: sticky;
        left: 0;
        z-index: 2;
        background-color: white; /* jika perlu */
    }
    .jan-input {
        font-size: 12px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        padding: 5px; /* Sesuaikan dengan ukuran yang Anda inginkan */
        width: 20px; /* Sesuaikan dengan lebar yang Anda inginkan */
    }
    .freeze-row{
        position: sticky;
        top : 0;
        background-color: white;
        z-index: 2;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between breadcrumb-content">
            <div class="col d-flex align-items-center">
                <a href="{{ route('bom-index') }}" class="btn btn-primary mr-2"><i aria-hidden="true"></i>Back</a>
                <h5 class="mb-0 text-end">Master Production Schedule</h5>
            </div>
            <div class="items-center">
            </div>

                      
        </div>
        <br>
        <form id="mpsForm" action="{{ route('mps2.store') }}" method="POST">
            @csrf
            <div class="col text-left">
                <button type="submit" class="btn btn-md btn-primary" name="s1_planning">S1 Planning: Ex-work (SO due date)</button>
                <a href="{{ route('gpa-indexgpadry') }}" class="btn btn-primary"><i class="fa-solid fa-car"></i>GPA Dry Type</a>
            </div>
            <br>
            <!-- Tambahkan kode untuk menampilkan pesan error -->
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div id="tabelmps" class="table-wrapper">
                <table class="table table-bordered mt-3">
                    <tbody>
                        @php
                            // Tentukan tahun yang ingin diperiksa
                            $yearToCheck = 2024; // Misalnya, tahun 2024

                            // Periksa apakah tahun tersebut adalah tahun kabisat atau tidak
                            $tahunKabisat = \Carbon\Carbon::create($yearToCheck, 1, 1)->isLeapYear();
                            
                            // Menghitung jumlah hari dalam tahun 2024
                            $totalDaysInYear = ($tahunKabisat ? 366 : 365);

                            // Menambahkan 8 hari
                            $totalDaysWithBuffer = $totalDaysInYear + 8;
                        @endphp

                        <tr>
                            <th colspan="{{ $totalDaysWithBuffer }}" style="text-align: center;">Kapasitas</th>
                        </tr>
                        <tr>
                            <td colspan="8" style="min-width: 145px; text-align: center;" class="freeze-column">PL 2</td>
                            @foreach ($kapasitasPL2 as $tanggal => $capacityPL2)
                                @php
                                    // Tentukan warna latar belakang berdasarkan nilai kapasitas
                                    $background_color = '';
                                    switch ($capacityPL2) {
                                        case 93:
                                            $background_color = 'background-color: #00FF00;';
                                            break;
                                        case 1:
                                            $background_color = 'background-color: #FFFF00;';
                                            break;
                                        case 0:
                                            $background_color = 'background-color: #FF0000;';
                                            break;
                                        default:
                                            $background_color = ''; // Tidak ada warna latar belakang
                                            break;
                                    }
                                @endphp
                                <td style="min-width: 57px; text-align: center; {{ $background_color }}">{{ $capacityPL2 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="8" style="min-width: 145px; text-align:center;" class="freeze-column">PL 3</td>
                            @foreach ($kapasitasPL3 as $tanggal => $capacityPL3)
                                @php
                                    // Tentukan warna latar belakang berdasarkan nilai kapasitas
                                    $background_color = '';
                                    switch ($capacityPL3) {
                                        case 6:
                                            $background_color = 'background-color: #00FF00;';
                                            break;
                                        case 1:
                                            $background_color = 'background-color: #FFFF00;';
                                            break;
                                        case 0:
                                            $background_color = 'background-color: #FF0000;';
                                            break;
                                        default:
                                            $background_color = ''; // Tidak ada warna latar belakang
                                            break;
                                    }
                                @endphp
                                <td style="min-width: 57px; text-align: center; {{ $background_color }}">{{ $capacityPL3 }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="8" style="min-width: 145px; text-align:center;" class="freeze-column">DRYTYPE</td>
                            @foreach ($kapasitasDrytype as $tanggal => $capacityDrytype)
                                @php
                                    // Tentukan warna latar belakang berdasarkan nilai kapasitas
                                    $background_color = '';
                                    switch ($capacityDrytype) {
                                        case 2:
                                            $background_color = 'background-color: #00FF00;';
                                            break;
                                        case 1:
                                            $background_color = 'background-color: #FFFF00;';
                                            break;
                                        case 0:
                                            $background_color = 'background-color: #FF0000;';
                                            break;
                                        default:
                                            $background_color = ''; // Tidak ada warna latar belakang
                                            break;
                                    }
                                @endphp
                                <td style="min-width: 57px; text-align: center; {{ $background_color }}">{{ $capacityDrytype }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th rowspan="2" class="freeze-column work-order-code" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Work Order Code</th>
                            <th rowspan="2" class="freeze-column kode-so" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Kode SO</th>
                            <th rowspan="2" class="freeze-column" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Line</th>
                            <th rowspan="2" class="freeze-column" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Project Name</th>
                            <th rowspan="2" class="freeze-column" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Due Date</th>
                            <th rowspan="2" class="freeze-column" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">KVA</th>
                            <th rowspan="2" class="freeze-column" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Qty</th>
                            <th rowspan="2" class="freeze-column" style="position: relative; text-align: center; white-space: nowrap; width: 200px; padding: 10px; vertical-align: middle;">Manhour Code</th>
                            @php
                                // Tentukan tahun yang ingin diperiksa
                                $yearToCheck = 2024; // Misalnya, tahun 2024

                                // Periksa apakah tahun tersebut adalah tahun kabisat atau tidak
                                $tahunKabisat = \Carbon\Carbon::create($yearToCheck, 1, 1)->isLeapYear();
                            @endphp
                            @php
                                $daysInMonths = [
                                    31, // Januari
                                    ($tahunKabisat ? 29 : 28), // Februari
                                    31, // Maret
                                    30, // April
                                    31, // Mei
                                    30, // Juni
                                    31, // Juli
                                    31, // Agustus
                                    30, // September
                                    31, // Oktober
                                    30, // November
                                    31, // Desember
                                ];
                            @endphp
                            
                            @for ($i = 0; $i < 12; $i++)
                                <th colspan="{{ $daysInMonths[$i] }}" style="text-align: center">{{ ucfirst(\Carbon\Carbon::create(2024, $i + 1, 1)->formatLocalized('%B')) }}</th>
                            @endfor
                        </tr>
                        <tr>
                            @foreach ($tanggalHeaders as $tanggal)
                                <th style="text-align: center">{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
                            @endforeach
                        </tr>
                        @foreach ($mps2s as $mps2)
                            {{-- @dd($mps2->deadline['month']); --}}
                            <tr>
                                <td class="freeze-column" style="position: relative; min-width: 165px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="id_wo" value="{{ $mps2->id_wo }}" disabled></td>
                                <td class="freeze-column" style="position: relative; min-width: 165px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="id_so" value="{{ $mps2->id_so }}" disabled></td>
                                <td class="freeze-column" style="position: relative; width: 200px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="production_line" value="{{ $mps2->production_line }}" disabled></td>
                                <td class="freeze-column" style="position: relative; width: 200px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="project" value="{{ $mps2->project }}" disabled></td>
                                <td class="freeze-column" style="position: relative; width: 200px; padding: 10px; text-align:center;">
                                    <input type="text" style="text-align:center;" class="form-control" name="deadline" value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $mps2->deadline['year'] . '-' . $mps2->deadline['month'] . '-' . $mps2->deadline['day'])->format('d-M-Y') }}" disabled>
                                </td>                                 
                                <td class="freeze-column" style="position: relative; width: 200px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="kva" value="{{ $mps2->kva }}" disabled></td>
                                <td class="freeze-column" style="position: relative; width: 200px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="qty_trafo" value="{{ $mps2->qty_trafo }}" disabled></td>
                                <td class="freeze-column" style="position: relative; width: 200px; padding: 10px; text-align:center;"><input type="text" style="text-align:center;" class="form-control" name="manhour_code" value="{{ $mps2->kd_manhour }}" disabled></td>
                                {{-- <td><input type="text" class="form-control jan-input" name="jan_input" value="{{ $mps2->qty_trafo }}"></td> --}}
                                @foreach ($tanggalHeaders as $tanggal)
                                    @php
                                        $formattedDeadline = \Carbon\Carbon::createFromFormat('Y-m-d', $mps2->deadline['year'] . '-' . $mps2->deadline['month'] . '-' . $mps2->deadline['day']);
                                        $inputDayMonth = $formattedDeadline->format('dm'); 
                                        $qty_trafo = $formattedDeadline->isSameDay($tanggal) ? $mps2->qty_trafo : '';
                                        $background_color = $formattedDeadline->isSameDay($tanggal) && $qty_trafo !== '' ? 'background-color: #FFA500;' : ''; 
                                    @endphp
                                    <td><input type="text" class="form-control jan-input" name="jan_{{ $inputDayMonth }}" value="{{ $qty_trafo }}" disabled style="{{ $background_color }}"></td>
                                @endforeach
                            </tr>
                        @endforeach
                        @for ($j = 1; $j <= 3; $j++)
                            <tr>
                                <td class="freeze-column" style="position: relative; min-width: 167px; padding: 10px;">
                                    <input type="text" class="form-control" name="id_wo[]" value="">
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 167px; padding: 10px;">
                                    <input type="text" class="form-control" name="id_so_new[]" value="" disabled>
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 85px; padding: 10px;">
                                    <input type="text" class="form-control" name="production_line[]" value="">
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 250px; padding: 10px;">
                                    <input type="text" class="form-control" name="project[]" value="">
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 150px; padding: 10px;">
                                    <input type="text" class="form-control" name="deadline[]" placeholder="YYYY-MM-DD" id="deadline_input" value="">
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 100px; padding: 10px;">
                                    <input type="text" class="form-control" name="kva[]" value="">
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 78px; padding: 10px;">
                                    <input type="text" class="form-control" name="qty_trafo[]" value="">
                                </td>
                                <td class="freeze-column" style="position: relative; min-width: 160px; padding: 10px;">
                                    <input type="text" class="form-control" name="manhour_code[]" value="" disabled>
                                </td>
                                @php
                                    $daysInMonths = [
                                        'January' => 31, 'February' => 28, 'March' => 31,
                                        'April' => 30, 'May' => 31, 'June' => 30,
                                        'July' => 31, 'August' => 31, 'September' => 30,
                                        'October' => 31, 'November' => 30, 'December' => 31,
                                    ];
    
                                    $totalDays = array_sum($daysInMonths); // Menghitung total jumlah hari dalam dua belas bulan
                                @endphp
                                @for ($i = 1; $i <= $totalDays; $i++)
                                    <td><input type="text" class="form-control jan-input" name="jan_{{ $i }}" disabled></td>
                                @endfor
                            </tr>
                            
                            
                        @endfor
                    </tbody>
                </table>   
            </div>
        </form>
        {{-- <form action="{{ route('mps2.delete') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin ingin menghapus MPS tersebut?')">Delete MPS</button>
        </form> --}}
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.table-wrapper').scroll(function() {
            var $th = $('.freeze-column');
            var scrollLeft = $('.table-wrapper').scrollLeft();
            $th.css('left', scrollLeft);
        });

        // Simpan nilai id_so saat halaman dimuat
        var originalIdSoValue = $('input[name="id_so"]').val();
        // Event handler untuk input id_wo
        $('input[name="id_wo"]').on('input', function() {
            // Ambil nilai dari input id_wo
            var id_wo_value = $(this).val();
            
            // Cek jika id_wo tidak sama dengan nilai yang sudah ada
            if (id_wo_value.trim() !== originalIdSoValue.replace(/\D/g, '')) {
                // Buat format untuk id_so
                var id_so_value = "S" + id_wo_value.replace(/\D/g, '').replace(/(.{1})(.{2})(.*)/, "$1/$2/$3");
                
                // Set nilai input id_so hanya jika id_wo yang baru tidak kosong
                $('input[name="id_so_new"]').val(id_so_value);
            } else {
                // Jika id_wo sama dengan nilai yang sudah ada, kembalikan nilai id_so yang asli saat halaman dimuat
                $('input[name="id_so"]').val(originalIdSoValue);
            }

            // Lakukan AJAX request untuk mengambil data manhour_code
            $.ajax({
                url: '/get-manhour-code/' + id_wo_value,
                type: 'GET',
                success: function(response) {
                    // Mengisi nilai input manhour_code dengan data yang diterima dari server
                    $('input[name="manhour_code"]').val(response.manhour_code);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Tampilkan pesan kesalahan jika terjadi kesalahan dalam permintaan
                }
            });
        });

        // Validasi format deadline
        $('input[name="deadline[]"]').on('blur', function() {
            var deadlineValue = $(this).val();
            var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            
            if (!dateRegex.test(deadlineValue)) {
                alert('Format deadline tidak sesuai. Harap gunakan format YYYY-MM-DD.');
                $(this).val(''); // Kosongkan nilai input
            }
        });

        // Transformasi format production line
        $('input[name="production_line[]"]').on('blur', function() {
            var productionLineValue = $(this).val().toLowerCase();
            
            if (productionLineValue === 'dry') {
                $(this).val('Dry');
            }
        });
    });
</script>
