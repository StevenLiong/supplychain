@extends('planner.template.bar')
@section('material', 'active')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">Upload Data Excel Material</h4>
       </div>
    </div>
    <div class="card-body">
      @if (session()->has('success'))
          <div class="alert alert-success" role="alert">
            {{ session('success') }}
          </div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
       <form action="{{ route('material-upload-excel-post') }}" method="POST" enctype="multipart/form-data">
         @csrf
          <div class="form-row">
             <div class="col-md-6 mb-3">
                <p>Input file dengan format .xlxs</p>
                <p>Pastikan format tabel sudah sesuai</p>
                <div class="custom-file">
                   <input type="file" name="file">
                </div>
             </div>
          </div>
          <div class="col text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
       </form>
       </div>
 </div>
@endsection