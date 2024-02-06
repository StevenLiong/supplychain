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
                    <label for="validationDefault01">Kode Finish Good</label>
                    <select class="form-control" name="id_fg" id="id_fg" required>
                        @foreach($dataBom as $bom)
                            <option value="{{ $bom->id_fg }}" {{ $bom->id_fg == $detailWo->id_fg ? 'selected' : '' }}>{{ $bom->id_fg }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Work Order Code</label>
                    <input type="text" class="form-control" name="id_wo" value="{{ $detailWo->id_wo }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">BOM Code</label>
                    <input type="text" class="form-control" name="id_boms" value="{{ $detailWo->id_boms }}"required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Man Hour Code</label>
                    <input type="text" class="form-control" name="id_standardize_work" value="{{ $detailWo->standardize_work->kd_manhour}}"required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">KVA</label>
                    <input type="text" class="form-control" name="kva" value="{{ $detailWo->kva }}"required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Sales Order</label>
                    <input type="text" class="form-control" name="id_so" value="{{ $detailWo->id_so }}"required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Start Date</label>
                    <input type="date" class="form-control datepicker" name="start_date" value="{{ $detailWo->start_date }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Finish Date</label>
                    <input type="date" class="form-control datepicker" name="finish_date" value="{{ $detailWo->finish_date }}"required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Quantity</label>
                    <input type="text" class="form-control" name="qty_trafo" value="{{ $detailWo->qty_trafo }}"required>
                </div>
                <!-- <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Kode Finish Good</label>
                    <input type="text" class="form-control" name="id_fg" value="{{ $detailWo->id_fg }}"required>
                </div> -->
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ URL::previous() }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
<!-- Tambahkan script flatpickr -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function getDataWO(idFg) {
        $.ajax({
            url: '/getdatawo/' + idFg,
            method: 'GET',
            success: function (data) {
                $('input[name="id_standardize_work"]').val(data.id_standardize_work);
                $('input[name="id_boms"]').val(data.id_boms);
                $('input[name="id_so"]').val(data.id_so);
                $('input[name="kva"]').val(data.kva);

                console.log(data.kd_manhour);
                console.log(data.id_boms);
                console.log(data.id_so);
                console.log(data.kva);
            },
            error: function (xhr, status, error) {
                console.log('Error fetching data:', status, error);
                console.log(xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $('#id_fg').on('change', function () {
            var idFg = $(this).val();
            getDataWO(idFg);
        });
    });
</script>



@endsection