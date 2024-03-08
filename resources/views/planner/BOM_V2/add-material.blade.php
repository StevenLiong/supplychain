@extends('planner.template.bar')
@section('content')
@section('bill-of-material-v2', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">Add Raw Material</h4>
       </div>
    </div>
    <div class="card-body">
       <form action="{{ route('bom.storematerial', ['id_bom' => $id_bom]) }}" method="post">
          @csrf
          <div class="form-row">
            <input type="hidden" name="id_boms" value="{{ $id_bom }}">
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Work Center<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="nama_workcenter" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Material Code<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="id_materialbom" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Material Name<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="nama_materialbom" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">UOM<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="uom_material" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Composite<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="qty_trafo" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Quantity<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="qty_material" required>
            </div>
          </div>
          <div class="col text-center">
            <button type="submit" class="btn btn-md btn-primary">Submit</button>
            <a href="{{ URL::previous() }}" class="btn btn-light">Cancel</a>
          </div>
       </form>
    </div>
 </div>
@endsection
