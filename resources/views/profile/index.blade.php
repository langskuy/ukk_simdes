@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                {{-- Header --}}
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @if(auth()->user()->role === 'admin')
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}">Dashboard</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">Data Pribadi</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold">Data Pribadi Warga</h1>
                    <p class="text-muted">Informasi data kependudukan Anda yang tercatat di sistem desa.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Data Kependudukan Card --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-person-vcard text-primary fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Identitas Kependudukan</h5>
                                <p class="text-muted small mb-0">Data ini bersumber dari Master Data Desa.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if($penduduk)
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small text-uppercase fw-bold">NIK</label>
                                    <div class="fs-5 fw-medium text-dark font-monospace">{{ $penduduk->nik }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small text-uppercase fw-bold">Nama Lengkap</label>
                                    <div class="fs-5 fw-medium text-dark">{{ $penduduk->nama }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small text-uppercase fw-bold">Jenis Kelamin</label>
                                    <div class="fs-5 fw-medium text-dark">
                                        {{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-muted small text-uppercase fw-bold">Alamat</label>
                                    <div class="fs-5 fw-medium text-dark">{{ $penduduk->alamat ?? '-' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning border-0 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                                <div>
                                    <strong>Data tidak ditemukan!</strong>
                                    <br>NIK Anda tidak terhubung dengan Master Data Desa. Silakan hubungi admin desa untuk
                                    sinkronisasi data.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Akun Card --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-shield-lock text-info fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Informasi Akun</h5>
                                <p class="text-muted small mb-0">Detail login aplikasi layanan desa.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Alamat Email</label>
                            <div class="fs-5 fw-medium text-dark">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                {{-- Logout Card --}}
                <div class="card shadow-sm border-0 rounded-4 bg-danger bg-opacity-10">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-danger bg-opacity-20 rounded-circle p-3 me-3">
                                    <i class="bi bi-box-arrow-right text-danger fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-danger">Keluar Aplikasi</h5>
                                    <p class="text-muted small mb-0">Akhiri sesi Anda di perangkat ini.</p>
                                </div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-danger px-4 fw-bold rounded-pill shadow-sm">
                                    Logout Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection