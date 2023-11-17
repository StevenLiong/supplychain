@extends('template.bar')
@section('content')
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
                    <input type="text" class="form-control" name="id_bom" value="{{ $dataBom->id_bom }}"required disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault02">Quantity</label>
                    <input type="text" class="form-control" name="qty_bom" value="{{ $dataBom->qty_bom }}"required >
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefaultUsername">BOM Status</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="bom_status" value="{{ $dataBom->bom_status }}"required >
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault03">UOM BOM</label>
                    <input type="text" class="form-control" name="uom_bom" value="{{ $dataBom->uom_bom }}"required >
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault05">Status</label>
                    @if ($dataBom->status == 1)
                            <td>
                                <input type="text" class="form-control" value="Completed"required disabled>
                            </td>
                        @else
                            <td>
                            <input type="text" class="form-control" value="Pending"required disabled>
                            </td>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationDefault05">Keterangan</label>
                    <input type="text" class="form-control" name="id_so" value="{{ $dataBom->keterangan }}"required disabled>
                </div>
            </div>
            <div class="col text-center">
                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection