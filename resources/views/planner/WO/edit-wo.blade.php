@extends('planner.template.bar')
@section('content')
@section('work-order', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Work Order</h4>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('wo.updatewo', ['id_wo' => $detailWo->id_wo]) }}">
            @method('PUT')
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Work Order Code</label>
                    <input type="text" class="form-control" name="id_wo" value="{{ $detailWo->id_wo }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">BOM Code</label>
                    <input type="text" class="form-control" name="id_boms" value="{{ $detailWo->id_boms }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Man Hour Code</label>
                    <input type="text" class="form-control" name="id_manhour" value="{{ $detailWo->id_manhour }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Sales Order</label>
                    <input type="text" class="form-control" name="id_so" value="{{ $detailWo->id_so }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Start Date</label>
                    <input type="text" class="form-control datepicker" name="start_date" value="{{ $detailWo->start_date }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Finish Date</label>
                    <input type="text" class="form-control datepicker" name="finish_date" value="{{ $detailWo->finish_date }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Quantity</label>
                    <input type="text" class="form-control" name="qty_trafo" value="{{ $detailWo->qty_trafo }}"required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ URL::previous() }}" class="btn btn-light">Cancel</a>
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