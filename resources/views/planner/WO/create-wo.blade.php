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
                    <select id="id_boms" name="id_boms" class="form-control" required>
                        <option value="">Choose...</option>
                        @foreach($detailBom as $bomId)
                            <option value="{{ $bomId }}">{{ $bomId }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_so">Sales Order</label>
                        <select class="form-control @error('id_so') is-invalid @enderror" id="id_so" name="id_so">
                            <option selected="" disabled="">Select Kode SO:</option>
                            @foreach ($dataSo as $so)
                            <option value="{{ $so->kode_so }}">{{ $so->kode_so }}</option>
                            @endforeach
                        </select>
                        @error('id_so')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Man Hour Code</label>
                    <select id="kd_manhour" name="kd_manhour" class="form-control" required>
                        <option value="">Choose...</option>
                        @foreach($dryCastResin as $kdmanhour)
                            <option value="{{ $kdmanhour }}">{{ $kdmanhour }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Start Date</label>
                    <input type="text" class="form-control datepicker" name="start_date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Finish Date</label>
                    <input type="text" class="form-control datepicker" name="finish_date" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Quantity</label>
                    <input type="text" class="form-control" name="qty_trafo" required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- Tambahkan script flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi datepicker
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d', // Format tanggal yang diinginkan
        enableTime: false, // Biarkan false jika tidak memerlukan waktu
    });
</script>
@endsection