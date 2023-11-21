@extends('template.bar')
@section('content')
@section('bill-of-material', 'active')
@section('main', 'show')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">New Raw Material</h4>
       </div>
    </div>
    <div class="card-body">
       <form>
          <div class="form-row">
             <div class="col-md-6 mb-3">
                <label for="validationDefault01">BOM Code</label>
                <input type="text" class="form-control" id="validationDefault01" value="TCVTHAH14444199DEDL3" readonly>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault02">UOM BOM</label>
                <input type="text" class="form-control" id="validationDefault02" value="xxxxxxxxxxxxxxxx" readonly>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefaultUsername">BOM Status</label>
                <div class="input-group">
                   <input type="text" class="form-control" id="validationDefaultUsername"  aria-describedby="inputGroupPrepend2" value="Active" readonly>
                </div>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault03">Status</label>
                <select class="form-control" id="validationDefault04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>...</option>
                    <option>Active</option>
                    <option>Non Active</option>
                 </select>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault04">Quantity</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="validationDefault05" aria-describedby="inputGroupPrepend2" value="2" readonly>
                </div>
             </div>
             <div class="col-md-6 mb-3">
                <label for="validationDefault05">Kode Finish Good</label>
                <input type="text" class="form-control" id="validationDefault06" value="xxxxxxxxxxxxxxxx" readonly>
             </div>
          </div>
          <hr>
          <div class="card-body">
            <form>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Material Code</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Material Name</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">UOM</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Composite</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Usage Of Tolerance(%)</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Cost Code</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationDefault01">Work Center</label>
                        <input type="text" class="form-control" id="validationDefault01" required>
                    </div>
                </div>
            </form>
          </div>
          <div class="col text-center">
            <a href="/BOM/Detail-BOM" class="btn btn-warning">Save</a>
            <a href="/BOM/Detail-BOM" class="btn btn-light">Cancel</a>
            
          </div>
       </form>
    </div>
 </div>
@endsection