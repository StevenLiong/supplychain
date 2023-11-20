@extends('produksi.layouts.app')

@section('content')
    <div class="wrapper">
        <section class="login-content" style="background-image: url('/templatetrafindo/assets/images/bgutama.png');">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card" style="opacity:90%">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center auth-content">
                                    <div class="col-lg-6 bg-primary content-left">
                                        <div class="p-3">
                                            <h1 class="mb-4 text-white"><b><span>Log In</span></b></h1>

                                    
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input id="email" type="email"
                                                                class="floating-input form-control " name="email"
                                                                placeholder="">
                                                            <label for="email" style="border-radius: 40px;">Email</label>

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input d="password" type="password"
                                                                class="floating-input form-control " name="password"
                                                                placeholder="">
                                                            <label for="password"
                                                                style="border-radius: 40px;">Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-light"  style="font-size:small">Log In</button>
                                                <div class="mt-0">
                                                    <br>
                                                    <a href="{{ route('password.request') }}"
                                                    class="text-white float-left" style="font-size: small">Forgot Password?</a>
                                                    <br>
                                                    <a href="{{ route('register') }}"
                                                    class="text-white float-left "  style="font-size: small">Register</a>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 text-center content-center">
                                        <img src="/templatetrafindo/assets/images/logotrafindo.png" class="img-fluid "
                                            alt="" width="300px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
