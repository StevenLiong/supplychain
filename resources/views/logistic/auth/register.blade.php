@extends('logistic.auth.layouts.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    </head>

    <body style="background-color: #fffff;">

    <div class="container"> 

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg" style="margin-top: 9rem; margin-bottom: 9rem;">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="{{ asset('/') }}assets/dist/img/img-login.jpg" alt="Login Image" class="img-fluid" style="max-width: 100%; height: 350px; margin: 20px;">
                            </div>
                
            <div class="col-lg-6">
                <div class="p-5 text-center">
                    <div class="col-lg-6 img-center d-flex">
                        <img src="{{ asset('/') }}assets/dist/img/logo-trafo.png" alt="Login Image" class="img-fluid" style="max-width: 100%; weight: 100px; height: 50px; margin: 10px;">
                    </div>
                    
                    <div class="text-center">
                        <h1 class="h5 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                
                    <form action="{{ url('/login') }}" method="get" class="user">
                    @csrf
                        <div class="form-group">
                            <input name="nama" type="text" class="form-control form-control-user @error('nama')is-invalid @enderror" id="exampleInputName" placeholder="Name"> 
                            
                            @error('nama')                        
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="form-group">
                            <input name="email" type="email" class="form-control form-control-user @error('email')is-invalid @enderror" id="exampleInputEmail" placeholder="Email Address">
                            
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input name="password" type="password" class="form-control form-control-user @error('password')is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                                    
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                        </div>
                    
                        <div class="col-sm-6">
                            <input name="password_confirmation" type="password" class="form-control form-control-user @error('password_confirmation')is-invalid @enderror" id="exampleRepeatPassword" placeholder="Repeat Password">
                            
                            @error('password_confirmation')                        
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                </div>
                        <button type="submit" class="btn primary btn-block btn-user" style="background-color: #EC5B5B; color:#ffffff">Register</button>
                    </form>
                    
                    <div class="text-center">
                        <a class="small" href="{{ url('/login')}}" style="color: #EC5B5B;">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script> --}}

    {{-- <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}

    </body>

    </html>
@endsection