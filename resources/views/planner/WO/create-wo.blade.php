@extends('planner.template.bar')
@section('content')
@section('work-order', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Create Work Order</h4>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('wo.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Work Order</label>
                    <input type="text" class="form-control" name="id_wo" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">BOM Code</label>
                    <input type="text" class="form-control" name="id_boms" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_fg">Kode Finish Good</label>
                        <select class="form-control @error('id_fg') is-invalid @enderror" id="id_fg" name="id_fg">
                            <option selected="" disabled="">Select Kode Finish Good:</option>
                            @foreach ($dataBom as $bom)
                                <option value="{{ $bom->id_fg }}">{{ $bom->id_fg }}</option>
                            @endforeach
                        </select>
                        @error('id_fg')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Sales Order</label>
                    <input type="text" class="form-control" name="id_so" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Standardize Work Code</label>
                    <input type="text" class="form-control" name="id_standardize_work" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Start Date</label>
                    <input type="date" class="form-control datepicker" name="start_date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Finish Date</label>
                    <input type="date" class="form-control datepicker" name="finish_date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Quantity</label>
                    <input type="text" class="form-control" name="qty_trafo" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">KVA</label>
                    <input type="text" class="form-control" name="kva" required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- Tambahkan script flatpickr
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi datepicker
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d', // Format tanggal yang diinginkan
        enableTime: false, // Biarkan false jika tidak memerlukan waktu
    });
</script> -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function getDataByIdFg(idFg) {
        $.ajax({
            url: '/getdataid-fg/' + idFg,
            method: 'GET',
            success: function (data) {
                // Isi nilai-nilai formulir berdasarkan data yang diterima dari server
                $('input[name="id_standardize_work"]').val(data.kd_manhour);
                $('input[name="id_boms"]').val(data.id_boms);
                $('input[name="qty_trafo"]').val(data.qty_trafo);
                $('input[name="id_so"]').val(data.id_so);
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
        $('#id_fg').on('change', function () {
            var idFg = $(this).val();
            getDataByIdFg(idFg);
        });
    });
</script>
@endsection