
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: linear-gradient(135deg, #2c5aa0, #1e3a5f); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-user-plus" style="font-size: 1.8rem;"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-2">Buat Akun Baru</h4>
                        <p class="text-muted small">Daftar untuk mengakses layanan desa</p>
                    </div>

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

                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email') }}" placeholder="nama@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="••••••••" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-circle me-2"></i>Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                   placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                    </form>

                    <hr class="my-3">

                    <p class="text-center text-muted small mb-0">
                        Sudah punya akun? 
                        <a href="{{ route('login.form') }}" class="fw-bold text-primary text-decoration-none">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection