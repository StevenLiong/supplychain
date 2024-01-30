@extends('planner.template.bar')
@section('content')
@section('bill-of-material', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Edit Data Finish Good</h4>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('fg.updatefg', ['kode_fg' => $dataFg->kode_fg]) }}">
            @method('PUT')
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Kode Finish Good</label>
                    <input type="text" class="form-control" name="kode_fg" value="{{ $dataFg->kode_fg }}" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Nama Item</label>
                    <input type="text" class="form-control" name="nama_item" value="{{ $dataFg->nama_item }}" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Max Kanban</label>
                    <input type="text" class="form-control" name="max_kanban" value="{{ $dataFg->max_kanban }}" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Stock On Hand</label>
                    <input type="text" class="form-control" name="stock_on_hand" value="{{ $dataFg->stock_on_hand }}" required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault01">Peruntukan Unit</label>
                    <input type="text" class="form-control" name="peruntukan_unit" value="{{ $dataFg->peruntukan_unit }}" required>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="{{ URL::previous() }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
