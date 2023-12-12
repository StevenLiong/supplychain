@extends('planner.template.bar')
@section('content')
@section('work-order', 'active')
@section('main', 'show')

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->


<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Create Work Order</h4>
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
                    @error('id_boms')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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
                    @error('id_so')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Standardize Work Code</label>
                    <input type="text" class="form-control" name="id_standardize_work" required disabled>
                    @error('id_standardize_work')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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
                    <input type="text" class="form-control" name="qty_trafo" required>
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
                // $('input[name="qty_trafo"]').val(data.qty_trafo);
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