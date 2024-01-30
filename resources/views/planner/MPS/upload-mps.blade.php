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
    <div class="card-body">
        <form action="{{ route('mps.store') }}" method="post">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Work Order</label>
                    <select id="id_wo" name="id_wo" class="form-control" required>
                        <option value="">Choose...</option>
                        @foreach($dataWo as $woId)
                            <option value="{{ $woId->id }}">{{ $woId->id_wo }}</option>
                            
                        @endforeach
                    </select>
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
                        <option value="DRY TYPE">DRY TYPE</option>
                        <option value="CTVT">CTVT</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">KVA</label>
                    <input type="text" class="form-control" name="kva" required>
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
                    <input type="text" class="form-control" name="qty_trafo" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Lead Time (Hari)</label>
                    <input type="text" class="form-control" name="lead_time" id="lead_time" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Deadline</label>
                    <input type="text" class="form-control datepicker" name="deadline" id="deadline" required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan script flatpickr -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi datepicker
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d', // Format tanggal yang diinginkan
        enableTime: false, // Biarkan false jika tidak memerlukan waktu
    });
    $(document).ready(function(){
        $('id_wo').on('change', function(){
            var id_wo = $(this).val();
            console.log(id_wo);
        });
    });
</script>
@endsection