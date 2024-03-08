@extends('planner.template.bar')
@section('content')
@section('bill-of-material-v2', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit BOM Info</h4>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('bom.updatebom', ['id_bom' => $dataBom->id_bom]) }}">
            @method('PUT')
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">BOM Code</label>
                    <input type="text" class="form-control" name="id_bom" value="{{ $dataBom->id_bom }}" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefaultUsername">BOM Status</label>
                    <select class="form-control" name="bom_status" required>
                        <option value="Aktif" {{ $dataBom->bom_status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $dataBom->bom_status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault02">Quantity</label>
                    <input type="text" class="form-control" name="qty_bom" value="{{ $dataBom->qty_bom }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">UOM BOM</label>
                    <select class="form-control" name="uom_bom" required>
                        <option value="Large" {{ $dataBom->uom_bom === 'Large' ? 'selected' : '' }}>Large</option>
                        <option value="Small" {{ $dataBom->uom_bom === 'Small' ? 'selected' : '' }}>Small</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Sales Order Code</label>
                    <input type="text" class="form-control" name="id_so" value="{{ $dataBom->id_so }}" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Finish Good Code</label>
                    <input type="text" class="form-control" name="id_fg" value="{{ $dataBom->id_fg }}" required disabled>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
