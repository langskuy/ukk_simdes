@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="text-center mb-5">
        <h2 class="fw-bold mb-3">
            <i class="fas fa-file-alt me-2"></i>Layanan Surat Desa
        </h2>
        <p class="text-muted fs-5">Ajukan berbagai jenis surat yang Anda butuhkan dengan mudah dan cepat</p>
    </div>

    {{-- Surat Grid --}}
    @php
        try {
            $currentUser = \Illuminate\Support\Facades\Auth::user();
        } catch (\Exception $e) {
            $currentUser = null;
        }
    @endphp
    <div class="row g-4">
        <!-- Surat Keterangan Usaha -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow border-0 service-card" style="border-radius: 15px; overflow: hidden;">
                <div style="height: 100px; background: linear-gradient(135deg, #10b981, #059669); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-briefcase" style="font-size: 2.5rem;"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-2">Surat Keterangan Usaha</h5>
                    <p class="card-text text-muted small mb-4">Untuk keperluan administrasi bisnis dan izin usaha.</p>
                    @if($currentUser)
                        <a href="{{ route('surat.usaha') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-arrow-right me-2"></i>Ajukan
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Surat Keterangan Domisili -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow border-0 service-card" style="border-radius: 15px; overflow: hidden;">
                <div style="height: 100px; background: linear-gradient(135deg, #3b82f6, #1e40af); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-home" style="font-size: 2.5rem;"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-2">Surat Keterangan Domisili</h5>
                    <p class="card-text text-muted small mb-4">Bukti tempat tinggal untuk berbagai keperluan.</p>
                    @if($currentUser)
                        <a href="{{ route('surat.domisili') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-arrow-right me-2"></i>Ajukan
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Surat Keterangan Tidak Mampu -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow border-0 service-card" style="border-radius: 15px; overflow: hidden;">
                <div style="height: 100px; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-hand-holding-heart" style="font-size: 2.5rem;"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-2">Surat Keterangan Tidak Mampu</h5>
                    <p class="card-text text-muted small mb-4">Untuk program bantuan sosial dan beasiswa.</p>
                    @if($currentUser)
                        <a href="{{ route('surat.tidak-mampu') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-arrow-right me-2"></i>Ajukan
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Surat Keterangan Pindah -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow border-0 service-card" style="border-radius: 15px; overflow: hidden;">
                <div style="height: 100px; background: linear-gradient(135deg, #ef4444, #dc2626); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-map-pin" style="font-size: 2.5rem;"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-2">Surat Keterangan Pindah</h5>
                    <p class="card-text text-muted small mb-4">Untuk perpindahan tempat tinggal ke desa lain.</p>
                    @if($currentUser)
                        <a href="{{ route('surat.pindah') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-arrow-right me-2"></i>Ajukan
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Surat Kelahiran -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow border-0 service-card" style="border-radius: 15px; overflow: hidden;">
                <div style="height: 100px; background: linear-gradient(135deg, #ec4899, #be185d); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-baby" style="font-size: 2.5rem;"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-2">Surat Keterangan Kelahiran</h5>
                    <p class="card-text text-muted small mb-4">Pendaftaran dan administrasi kelahiran bayi.</p>
                    @if($currentUser)
                        <a href="{{ route('surat.kelahiran') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-arrow-right me-2"></i>Ajukan
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Surat Keterangan Lainnya -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow border-0 service-card" style="border-radius: 15px; overflow: hidden;">
                <div style="height: 100px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-file-pdf" style="font-size: 2.5rem;"></i>
                </div>
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-2">Surat Keterangan Lainnya</h5>
                    <p class="card-text text-muted small mb-4">Surat lainnya sesuai kebutuhan Anda.</p>
                    @if($currentUser)
                        <a href="{{ route('surat.lainnya') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-arrow-right me-2"></i>Ajukan
                        </a>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-primary btn-sm w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Button --}}
    @if($currentUser)
    <div class="mt-5 text-center">
        <a href="{{ route('surat.history') }}" class="btn btn-outline-primary btn-lg fw-bold">
            <i class="fas fa-history me-2"></i>Lihat Riwayat Pengajuan Saya
        </a>
    </div>
    @endif
</div>

<style>
.service-card {
    transition: all 0.3s ease;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(44, 90, 160, 0.2) !important;
}
</style>
@endsection