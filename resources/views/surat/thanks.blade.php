@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow border-0 rounded-3 text-center">
                <div class="card-body py-5">
                    <div style="font-size: 4rem; margin-bottom: 1rem; color: #28a745;">
                        ✓
                    </div>
                    <h2 class="fw-bold mb-2">Pengajuan Berhasil!</h2>
                    <p class="text-muted fs-5 mb-4">
                        Terima kasih telah mengajukan surat. Pengajuan Anda telah kami terima dan akan diproses dalam 1-3 hari kerja.
                    </p>

                    <div class="alert alert-info mb-4">
                        <small class="text-start d-block">
                            <strong>📌 Informasi penting:</strong><br>
                            - Anda dapat mengecek status pengajuan di halaman riwayat<br>
                            - Notifikasi akan dikirim ketika surat sudah siap<br>
                            - Surat dapat diambil di kantor desa pada jam kerja
                        </small>
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('surat.history') }}" class="btn btn-primary fw-semibold">
                            📊 Lihat Riwayat Pengajuan
                        </a>
                        <a href="{{ route('beranda') }}" class="btn btn-outline-secondary fw-semibold">
                            🏠 Ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
