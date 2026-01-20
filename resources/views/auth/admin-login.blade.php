@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="p-5 text-center text-white"
                    style="background: linear-gradient(135deg, #1e1e2d 0%, #3a0ca3 100%);">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Admin Panel</h3>
                    <p class="small text-white-50 mb-0">Wonokasian Digital Center</p>
                </div>
                <div class="card-body p-4 p-lg-5">
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 small mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.login.attempt') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-muted">EMAIL ADMINISTRATOR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i
                                        class="bi bi-person text-muted"></i></span>
                                <input type="email" name="email" id="email" class="form-control border-0 bg-light"
                                    placeholder="admin@desa.id" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label small fw-bold text-muted">KATA SANDI</label>
                                <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" name="password" id="password" class="form-control border-0 bg-light"
                                    placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm"
                            style="background: #4361ee; border: none;">
                            MASUK KE PANEL <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>



                        <div class="text-center mt-4">
                            <a href="{{ route('beranda') }}" class="text-decoration-none small text-muted">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f4f7fe !important;
        }

        .navbar,
        footer {
            display: none !important;
        }

        main {
            padding: 0 !important;
        }
    </style>
@endsection