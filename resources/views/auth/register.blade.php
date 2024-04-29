@extends('produksi.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="" selected disabled>Pilih Role</option>
                                    <option value="1">Logistic</option>
                                    <option value="2">Planer</option>
                                    <option value="3">Standardized Work</option>
                                    <option value="4">Resource Work Planning</option>
                                    <option value="5">PPIC</option>
                                    <option value="6">Purchaser</option>
                                    <option value="7">Planner Versi Lama</option>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Register</button>
                                <a href="{{ route('login') }}" type="button" class="btn btn-secondary">Back to Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Meta tag untuk menyimpan route login -->
{{-- <meta name="login-route" content="{{ route('login') }}"> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');

        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Menghentikan proses submit form

            // Simulasi proses submit form (misalnya AJAX request)
            fetch(form.action, {
                method: form.method,
                body: new URLSearchParams(new FormData(form)),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Menampilkan alert
                    alert('Akun berhasil dibuat!');
                } else {
                    alert('Ada kesalahan dalam proses pendaftaran.');
                }
            })
            // .catch(error => {
            //     console.error('Error:', error);
            //     alert('Ada kesalahan dalam proses pendaftaran.');
            // });
        });
    });
</script>


@endsection
