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
                    <input type="text" class="form-control" name="id_wo" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Project Name</label>
                    <input type="text" class="form-control" name="project" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Production Line</label>
                    <input type="text" class="form-control" name="production_line" required>
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
                    <input type="text" class="form-control" name="deadline" id="deadline" required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection