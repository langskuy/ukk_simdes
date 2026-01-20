@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: linear-gradient(135deg, #2c5aa0, #1e3a5f); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-sign-in-alt" style="font-size: 1.8rem;"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-2">Masuk ke Akun Anda</h4>
                        <p class="text-muted small">Akses layanan digital desa</p>
                    </div>

                    {{-- Status/Success Message --}}
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-circle mt-1 me-2"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('login.attempt') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                        </div>

                        <div class="mb-2">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="••••••••" required>
                        </div>

                        <div class="text-end mb-4">
                            <a href="{{ route('password.request') }}" class="small fw-bold text-decoration-none">
                                Lupa Password?
                            </a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </form>

                    <hr class="my-3">

                    <p class="text-center text-muted small mb-0">
                        Belum punya akun? 
                        <a href="{{ route('register.form') }}" class="fw-bold text-primary text-decoration-none">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
