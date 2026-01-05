@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-8">
            <h1 class="mb-1 fw-bold">Admin Dashboard</h1>
            <p class="text-muted mb-0">Ringkasan cepat layanan desa — pengaduan, surat, kegiatan, dan pengguna.</p>
        </div>
        <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('warga.dashboard') }}" class="btn btn-outline-primary me-2">Lihat Dashboard Warga</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </div>

    {{-- Top stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-4 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6 text-danger"><i class="bi bi-bell-fill"></i></div>
                        <div>
                            <h6 class="text-muted mb-1">Pengaduan</h6>
                            <h3 class="mb-0">{{ $pengaduan_count }}</h3>
                            <small class="text-muted">{{ $pengaduan_new }} baru</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.pengaduan.index') }}" class="small">Kelola pengaduan →</a>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6 text-info"><i class="bi bi-calendar-event-fill"></i></div>
                        <div>
                            <h6 class="text-muted mb-1">Kegiatan</h6>
                            <h3 class="mb-0">{{ $kegiatan_count }}</h3>
                            <small class="text-muted">Aktif</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.kegiatan.index') }}" class="small">Kelola kegiatan →</a>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6 text-warning"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <h6 class="text-muted mb-1">Surat</h6>
                            <h3 class="mb-0">{{ $surat_count }}</h3>
                            <small class="text-muted">{{ $surat_new }} menunggu</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.surat.index') }}" class="small">Kelola surat →</a>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="me-3 display-6 text-success"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <h6 class="text-muted mb-1">Pengguna</h6>
                            <h3 class="mb-0">{{ $user_count }}</h3>
                            <small class="text-muted">Terdaftar</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('admin.users.index') }}" class="small">Kelola pengguna →</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick actions + activity --}}
    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Aktivitas Terbaru</h5>
                        <small class="text-muted">Ringkasan 7 hari</small>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <h6 class="mb-1">Pengaduan Baru</h6>
                                <p class="display-6 fw-bold text-danger mb-0">{{ $pengaduan_new }}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3">
                                <h6 class="mb-1">Surat Menunggu</h6>
                                <p class="display-6 fw-bold text-warning mb-0">{{ $surat_new }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-danger me-2">Lihat Pengaduan</a>
                        <a href="{{ route('admin.surat.index') }}" class="btn btn-outline-warning">Lihat Surat</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="mb-3">Tindakan Cepat</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-primary">➕ Tambah Kegiatan</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-success">👥 Kelola Pengguna</a>
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-danger">📩 Tinjau Pengaduan</a>
                        <a href="{{ route('admin.surat.index') }}" class="btn btn-warning">✉️ Proses Surat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer notes --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="text-muted small">Tip: Gunakan tombol "Tindakan Cepat" untuk operasi yang sering dilakukan. Semua link menuju halaman manajemen tetap sama.</div>
        </div>
    </div>
</div>
@endsection
