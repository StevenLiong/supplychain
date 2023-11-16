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

    <title>Login</title>

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
        
                <div class="col-xl-10 col-lg-12 col-md-9 ">
        
                    <div class="card o-hidden border-0 shadow-lg" style="margin-top: 9rem; margin-bottom: 9rem;">
                        <div class="card-body p-0 ">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block text-center">
                                    <img src="{{ asset('/') }}assets/dist/img/img-login.jpg" alt="Login Image" class="img-fluid" style="max-width: 100%; weight: 400px; height: 400px; margin: 30px;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5 textcenter">
                                        <div class="col-lg-6 img-center d-flex ">
                                            <img src="{{ asset('/') }}assets/dist/img/logo-trafo.png" alt="Login Image" class="img-fluid" style="justify-content-center; max-width: 100%; weight: 50px; height: 50px; margin: 10px;">
                                        </div>

                                        <div class="text-center">
                                            <h1 class="h5 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                            <form action="{{ url('/dashboard')}}" method="get" class="user">
                                                @csrf
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                    <div class="form-group">
                                                        <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                                    </div>
                                                    <div class="form-group">
                                                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox small">
                                                            <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                                                            <label class="custom-control-label" for="customCheck" style="margin-top: 0pt; margin-bottom: 1ch;">Remember Me</label>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn primary btn-block btn-user" style="background-color: #EC5B5B; color:#ffffff">Login</button>
                                            </form>

                                        <div class="text-center">
                                            <a class="small" href="{{ url('/')}}" style="color: #EC5B5B;"> Don't have an account yet? Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                </div>
        
            </div>
        
        </div>
        

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    </body>

    </html>
@endsection
