@extends('layouts.app')

@section('content')
<?php
$user = auth()->user();
$surats = \App\Models\Surat::where('user_id', $user->id)->latest()->take(8)->get();
$kegiatanList = \App\Models\Kegiatan::latest()->take(4)->get();

// Calculate statistics
$totalSurat = \App\Models\Surat::where('user_id', $user->id)->count();
$diajukan = \App\Models\Surat::where('user_id', $user->id)->where('status', 'diajukan')->count();
$selesai = \App\Models\Surat::where('user_id', $user->id)->where('status', 'selesai')->count();
$ditolak = \App\Models\Surat::where('user_id', $user->id)->where('status', 'ditolak')->count();
$totalKegiatan = \App\Models\Kegiatan::count();
?>

<div class="container-fluid py-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    
    {{-- Header Section --}}
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="text-white">
                        <h1 class="display-5 fw-bold mb-2">Halo, {{ Auth::user()->name }} 👋</h1>
                        <p class="fs-5 opacity-90">Dashboard Warga Desa Wonokasian</p>
                        <p class="small opacity-75">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>
                <div class="col-12 col-lg-6 text-lg-end">
                    <div class="d-flex gap-2 flex-wrap justify-content-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('desa.profile') }}" class="btn btn-light fw-bold px-4">
                            <i class="bi bi-info-circle me-2"></i>Profil Desa
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-outline-light fw-bold px-4">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="container py-5">
        <div class="row g-3 mb-5">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-white-50 mb-1">Total Pengajuan</p>
                                <h3 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $totalSurat }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="bi bi-file-earmark-text fs-5"></i>
                            </div>
                        </div>
                        <small class="text-white-50">Semua pengajuan surat Anda</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-white mb-1">Sedang Diproses</p>
                                <h3 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $diajukan }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="bi bi-hourglass-split fs-5"></i>
                            </div>
                        </div>
                        <small class="text-white">Menunggu admin memproses</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-white-50 mb-1">Selesai</p>
                                <h3 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $selesai }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="bi bi-check-circle fs-5"></i>
                            </div>
                        </div>
                        <small class="text-white-50">Siap diambil / download</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden h-100 stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-white-50 mb-1">Ditolak</p>
                                <h3 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $ditolak }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="bi bi-exclamation-circle fs-5"></i>
                            </div>
                        </div>
                        <small class="text-white-50">Memerlukan perbaikan</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Action Buttons --}}
        <div class="row g-3 mb-5">
            <div class="col-12">
                <div class="card border-0 rounded-4 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h6 class="text-muted mb-3 fw-bold">⚡ Aksi Cepat</h6>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="{{ route('surat.create') }}" class="btn btn-primary w-100 rounded-3 fw-bold py-3">
                                    <i class="bi bi-plus-circle me-2"></i>Ajukan Surat Baru
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="{{ route('surat.history') }}" class="btn btn-outline-primary w-100 rounded-3 fw-bold py-3">
                                    <i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="{{ route('pengaduan.create') }}" class="btn btn-danger w-100 rounded-3 fw-bold py-3">
                                    <i class="bi bi-exclamation-octagon me-2"></i>Ajukan Pengaduan
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="{{ route('pengaduan.history') }}" class="btn btn-outline-danger w-100 rounded-3 fw-bold py-3">
                                    <i class="bi bi-list-check me-2"></i>Riwayat Pengaduan
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="{{ route('desa.profile') }}" class="btn btn-outline-info w-100 rounded-3 fw-bold py-3">
                                    <i class="bi bi-building me-2"></i>Profil Desa
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <a href="{{ route('surat') }}" class="btn btn-outline-secondary w-100 rounded-3 fw-bold py-3">
                                    <i class="bi bi-info-circle me-2"></i>Jenis Surat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="row g-4 mb-5">
            {{-- Pengajuan Surat Section --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 rounded-4 shadow-lg h-100">
                    <div class="card-header border-0 bg-white rounded-4 p-4 pb-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                    <i class="bi bi-list-check text-primary fs-5"></i>
                                </div>
                                <h5 class="card-title fw-bold mb-0">Pengajuan Surat Terbaru</h5>
                            </div>
                            <a href="{{ route('surat.history') }}" class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if($surats->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Jenis Surat</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Tanggal</th>
                                            <th class="border-0 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($surats as $surat)
                                        <tr class="align-middle">
                                            <td>
                                                <div class="fw-semibold">{{ $surat->jenis_surat }}</div>
                                                @if($surat->keterangan)
                                                    <small class="text-muted d-block">{{ Str::limit($surat->keterangan, 40) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($surat->status === 'diajukan')
                                                    <span class="badge bg-warning text-dark rounded-pill">⏳ Diajukan</span>
                                                @elseif($surat->status === 'selesai')
                                                    <span class="badge bg-success rounded-pill">✓ Selesai</span>
                                                @elseif($surat->status === 'ditolak')
                                                    <span class="badge bg-danger rounded-pill">✗ Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary rounded-pill">{{ $surat->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $surat->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('surat.history') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-inbox fs-1 text-muted opacity-50"></i>
                                </div>
                                <p class="text-muted mb-3">Belum ada pengajuan surat</p>
                                <a href="{{ route('surat.create') }}" class="btn btn-primary btn-sm rounded-3">
                                    <i class="bi bi-plus-circle me-1"></i>Ajukan Surat Sekarang
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kegiatan Desa Section --}}
            <div class="col-12 col-lg-4">
                {{-- Kegiatan Cards --}}
                <div class="card border-0 rounded-4 shadow-lg h-100">
                    <div class="card-header border-0 bg-white rounded-4 p-4 pb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                <i class="bi bi-calendar-event text-info fs-5"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-0">Kegiatan Desa</h5>
                        </div>
                        <p class="text-muted small mb-0 mt-2">Total {{ $totalKegiatan }} kegiatan</p>
                    </div>
                    <div class="card-body p-4">
                        @if($kegiatanList->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($kegiatanList as $item)
                                <div class="list-group-item border-bottom-light py-3 px-0">
                                    <div class="d-flex gap-3">
                                        @if($item->foto)
                                            <a href="{{ route('kegiatan.show', $item) }}">
                                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="rounded-2" style="width: 60px; height: 60px; object-fit: cover;">
                                            </a>
                                        @else
                                            <div class="bg-light rounded-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold"><a href="{{ route('kegiatan.show', $item) }}" class="text-reset">{{ Str::limit($item->judul, 30) }}</a></h6>
                                            <small class="text-muted d-block">📅 {{ $item->tanggal ? $item->tanggal->format('d M Y') : '—' }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-calendar-x fs-1 text-muted opacity-50"></i>
                                <p class="text-muted mt-3 small">Belum ada kegiatan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Information Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-12 col-lg-6">
                <div class="card border-0 rounded-4 shadow-sm bg-gradient-info text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="bi bi-clock-history fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-white-50 mb-1">Waktu Pemrosesan</h6>
                                <h4 class="fw-bold mb-0">1-3 Hari Kerja</h4>
                            </div>
                        </div>
                        <p class="text-white-50 small mb-0">Pengajuan surat desa akan diproses sesuai antrian dan biasanya selesai dalam 1-3 hari kerja.</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-0 rounded-4 shadow-sm bg-gradient-danger text-white" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="bi bi-telephone fs-5"></i>
                            </div>
                            <div>
                                <h6 class="text-white-50 mb-1">Hubungi Kami</h6>
                                <h4 class="fw-bold mb-0">085730151992</h4>
                            </div>
                        </div>
                        <p class="text-white-50 small mb-0">Untuk pertanyaan atau keperluan darurat, hubungi customer service kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1.5rem 3rem rgba(0,0,0,0.2) !important;
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }

    .list-group-item {
        background-color: transparent;
        border-color: rgba(0,0,0,.125);
    }

    .list-group-item:last-child {
        border-bottom: none !important;
    }

    .border-bottom-light {
        border-bottom: 1px solid rgba(0,0,0,.1) !important;
    }

    @media (max-width: 768px) {
        .display-5 {
            font-size: 2rem;
        }
    }
</style>
@endsection
