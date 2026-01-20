@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-key" style="font-size: 1.8rem;"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-2">Lupa Password?</h4>
                        <p class="text-muted small">Masukkan email Anda untuk menerima link reset password.</p>
                    </div>

                    {{-- Success Message --}}
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email Terdaftar
                            </label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Link Reset
                        </button>
                    </form>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small fw-bold">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
