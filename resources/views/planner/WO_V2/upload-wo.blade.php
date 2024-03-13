@extends('planner.template.bar')
@section('content')
@section('work-order-v2', 'active')
@section('main', 'show')

<div class="card">
    <div class="card-header d-flex justify-content-between">
       <div class="header-title">
        <h4 class="card-title">Upload WO</h4>
       </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card-body">
      @if (session()->has('success'))
          <div class="alert alert-success" role="alert">
            {{ session('success') }}
          </div>
      @endif
       <form action="{{ route('wo_v2-upload-excel-post') }}" method="POST" enctype="multipart/form-data">
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