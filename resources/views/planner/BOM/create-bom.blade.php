@extends('planner.template.bar')
@section('content')
@section('bill-of-material', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">Create BOM</h4>
       </div>
    </div>
    <div class="card-body">
       <form action="{{route('bom.store')}}" method="post">
       @csrf
         <div class="form-row">
            <div class="col-md-6 mb-3">
               <label for="validationDefault01">BOM Code<span class="text-danger"> *</span></label>
               <input type="text" class="form-control" name="id_bom" required>
            </div>
            <div class="col-md-6 mb-3">
               <label for="validationDefault01">BOM Status</label>
               <input type="text" class="form-control" name="qty_bom" value="Aktif" disabled>
            </div>
            <div class="col-md-6 mb-3">
               <label for="validationDefault01">Quantity<span class="text-danger"> *</span></label>
               <input type="text" class="form-control" name="qty_bom" required>
            </div>
            <div class="col-md-6 mb-3">
               <label for="validationDefault01">UOM BOM<span class="text-danger"> *</span></label>
                  <div class="input-group">
                     <select class="form-control" name="uom_bom" required>
                           <option value="Large">Large</option>
                           <option value="Small">Small</option>
                     </select>
                  </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="validationDefault01">Sales Order Code<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="id_so" required>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault01">Finish Good Code<span class="text-danger"> *</span></label>
                <input type="text" class="form-control" name="id_fg" required>
             </div>
         </div>
         <div class="col text-center">
         <button type="submit" class="btn btn-md btn-primary">Submit</button>
       </form>
    </div>
    </div>
@endsection
