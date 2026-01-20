@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div
                                style="width: 60px; height: 60px; margin: 0 auto 1rem; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class="fas fa-lock-open" style="font-size: 1.8rem;"></i>
                            </div>
                            <h4 class="fw-bold text-primary mb-2">Reset Password</h4>
                            <p class="text-muted small">Buat password baru untuk akun Anda.</p>
                        </div>

                        {{-- Error Messages --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</div>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $email ?? old('email') }}" required readonly>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password Baru
                                </label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Min. 8 karakter" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-check-circle me-2"></i>Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Ulangi password baru" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">
                                <i class="fas fa-save me-2"></i>Simpan Password Baru
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection