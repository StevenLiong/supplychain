@extends('planner.template.bar')
@section('content')
@section('bill-of-material-v2', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">Edit Raw Material</h4>
       </div>
    </div>
        <div class="card-body">
            <form method="POST" action="{{ route('bom.update', ['id_materialbom' => $detailbomItem->id_materialbom, 'id_bom' => $id_bom]) }}">
                @method('PUT')
                @csrf
                <input type="hidden" name="id_bom" value="{{ $id_bom }}">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Work Center</label>
                        <input type="text" class="form-control" name="nama_workcenter" value="{{old('nama_workcenter', $detailbomItem->nama_workcenter) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Material Code</label>
                        <input type="text" class="form-control" name="id_materialbom" value="{{ old('id_materialbom',$detailbomItem->id_materialbom) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Material Name</label>
                        <input type="text" class="form-control" name="nama_materialbom" value="{{ old('nama_materialbom', $detailbomItem->nama_materialbom) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">UOM</label>
                        <input type="text" class="form-control" name="uom_material" value="{{ old('uom_material',$detailbomItem->uom_material )}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Quantity Trafo</label>
                        <input type="text" class="form-control" name="qty_trafo" value="{{ old('qty_trafo',$detailbomItem->qty_trafo )}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Quantity Material</label>
                        <input type="text" class="form-control" name="qty_material" value="{{ old('qty_material',$detailbomItem->qty_material )}}">
                    </div>

                </div>
                    <div class="col text-center">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ URL::previous() }}" class="btn btn-light">Cancel</a>
                    </div>
        </div>
            </form>
 </div>
@endsection