@extends('planner.template.bar')
@section('content')
@section('mps', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Input MPS</h4>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
        <form action="{{ route('mps.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="id_fg">Work Order</label>
                        <select class="form-control @error('id_wo') is-invalid @enderror" id="id_wo" name="id_wo">
                            <option selected="" disabled="">Select Kode Work Order:</option>
                            @foreach ($dataWo as $wo)
                                <option value="{{ $wo->id_wo }}">{{ $wo->id_wo }}</option>
                            @endforeach
                        </select>
                        @error('id_wo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Project Name</label>
                    <input type="text" class="form-control" name="project" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Production Line</label>
                    <select name="production_line" id="production_line" class="form-control">
                        <option>Choose...</option>
                        <option value="PL2">PL2</option>
                        <option value="PL3">PL3</option>
                        <option value="Drytype">Dry Type</option>
                        <option value="CTVT">CTVT</option>
                        <option value="REPAIR">REPAIR</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">KVA</label>
                    <input type="text" class="form-control" name="kva" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Jenis Trafo</label>
                    <select name="jenis" id="jenis" class="form-control">
                        <option>Choose...</option>
                        <option value="Oil Trafo">Oil Trafo</option>
                        <option value="Dry Type">Dry Type</option>
                        <option value="CTVT">CTVT</option>
                    </select>
                    {{-- <input type="text" class="form-control" name="jenis" required> --}}
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Quantity</label>
                    <input type="text" class="form-control" name="qty_trafo" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Deadline</label>
                    <input type="date" class="form-control datepicker" name="deadline" required>
                    <small id="keteranganDeadline" class="form-text text-muted"></small>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/fullcalendar.min.js"></script>
<script>
    function getDataByIdWo(idWo) {
        $.ajax({
            url: '/getdataid-wo/' + idWo,
            method: 'GET',
            success: function (data) {
                // Isi nilai-nilai formulir berdasarkan data yang diterima dari server
                $('input[name="qty_trafo"]').val(data.qty_trafo);
                $('input[name="kva"]').val(data.kva);
            },
            error: function (xhr, status, error) {
                // Handle error jika diperlukan
                console.log('Error fetching data:', status, error);
                console.log(xhr.responseText); // Log the response for further inspection
            }
        });
    }

    // Event listener untuk perubahan nilai pada input id_fg
    $(document).ready(function () {
        $('#id_wo').on('change', function () {
            var idWo = $(this).val();
            getDataByIdWo(idWo);
        });
    });

    $(document).ready(function () {
        $('input[name="deadline"]').on('change', function () {
            var selectedDate = $(this).val();
            var selectedProductionLine = $('#production_line').val();

            $.ajax({
                url: '/get-capacity-by-date',
                method: 'GET',
                data: {
                    selected_date: selectedDate,
                    production_line: selectedProductionLine,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    console.log(response); // Tambahkan log untuk melihat response dari server
                    var capacity = response.capacity;
                    console.log(capacity);

                    // Pastikan response memiliki properti 'capacity'
                    if (capacity !== null && capacity !== undefined) {
                        // Menampilkan keterangan sesuai dengan kapasitas
                        if (selectedProductionLine === 'Drytype') {
                            $('#keteranganDeadline').html('Kapasitas Dry Type tersisa ' + capacity + ' unit dari maximum kapasitas 2 unit');
                        } else if (selectedProductionLine === 'PL2') {
                            $('#keteranganDeadline').html('Kapasitas Production Line 2 yang masih bisa adalah ' + capacity + ' dari 93 unit');
                        } else if (selectedProductionLine === 'PL3') {
                            $('#keteranganDeadline').html('Kapasitas Production Line 3 yang masih bisa adalah ' + capacity + ' dari 6 unit');
                        } else {
                            $('#keteranganDeadline').html('Produksi line tidak valid');
                        }
                    } else {
                        // Handle jika capacity null atau undefined
                        if (selectedProductionLine === 'Drytype') {
                            $('#keteranganDeadline').html('Kapasitas Dry Type yang masih bisa adalah 0 dari 2 unit');
                        } else if (selectedProductionLine === 'PL2') {
                            $('#keteranganDeadline').html('Kapasitas Production Line 2 yang masih bisa adalah 0 dari 93 unit');
                        } else if (selectedProductionLine === 'PL3') {
                            $('#keteranganDeadline').html('Kapasitas Production Line 3 yang masih bisa adalah 0 dari 6 unit');
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error fetching capacity data:', status, error);
                    console.log(xhr.responseText);
                }
            });
        });
        $('input[name="deadline"]').on('change', function () {
            var selectedDate = $(this).val();
            // var selectedProductionLine = $('#production_line').val();

            // Ajax request untuk mendapatkan data hari libur dari server
            $.ajax({
                url: '/get-holiday',
                method: 'GET',
                data: {
                    selected_date: selectedDate,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    // Jika tanggal adalah hari libur, tampilkan pesan dalam bentuk alert
                    if (response.is_holiday) {
                        alert('Tanggal yang dipilih adalah hari libur.');
                        // Menonaktifkan tombol submit
                        $('button[type="submit"]').prop('disabled', true);
                    }else {
                        // Mengaktifkan kembali tombol submit jika tidak ada hari libur
                        $('button[type="submit"]').prop('disabled', false);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error fetching holiday data:', status, error);
                    console.log(xhr.responseText);
                }
            });
        });
    });

    // $(document).ready(function () {
    //     $('input[name="deadline"]').on('change', function () {
    //         var selectedDate = $(this).val();
    //         // var selectedProductionLine = $('#production_line').val();

    //         // Ajax request untuk mendapatkan data hari libur dari server
    //         $.ajax({
    //             url: '/get-holiday',
    //             method: 'GET',
    //             data: {
    //                 selected_date: selectedDate,
    //                 _token: '{{ csrf_token() }}',
    //             },
    //             success: function (response) {
    //                 // Jika tanggal adalah hari libur, tampilkan pesan dalam bentuk alert
    //                 if (response.is_holiday) {
    //                     alert('Tanggal yang dipilih adalah hari libur.');
    //                 } else {
    //                     $('input[name="deadline"]').prop('disabled', false);
    //                     $('#keteranganDeadline').html('');
    //                 }
    //             },
    //             error: function (xhr, status, error) {
    //                 console.log('Error fetching holiday data:', status, error);
    //                 console.log(xhr.responseText);
    //             }
    //         });
    //     });
    // });


</script>


@endsection
