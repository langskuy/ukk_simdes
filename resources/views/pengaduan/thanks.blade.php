@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow border-0 rounded-4 text-center">
                    <div class="card-body py-5">
                        <div style="font-size: 4rem; margin-bottom: 1rem; color: #dc3545;">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Pengaduan Terkirim!</h2>
                        <p class="text-muted fs-5 mb-4">
                            Terima kasih telah menyampaikan aspirasi/pengaduan Anda. Laporan Anda telah kami terima dan akan
                            segera ditinjau oleh tim administrasi desa.
                        </p>

                        <div class="alert alert-danger bg-danger bg-opacity-10 border-0 mb-4 text-start">
                            <small class="d-block">
                                <strong>📌 Informasi selanjutnya:</strong><br>
                                - Status pengaduan dapat dipantau di halaman riwayat<br>
                                - Kami akan memproses setiap laporan secara objektif<br>
                                - Pastikan nomor HP Anda aktif jika diperlukan klarifikasi lanjutan
                            </small>
                        </div>

                        <div class="d-flex gap-2 justify-content-center flex-wrap">
                            <a href="{{ route('pengaduan.history') }}" class="btn btn-danger fw-bold px-4">
                                <i class="bi bi-clock-history me-2"></i>Riwayat Pengaduan
                            </a>
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard') }}"
                                class="btn btn-outline-secondary fw-semibold px-4">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection