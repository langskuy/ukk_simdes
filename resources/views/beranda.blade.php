<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Wonokasian - Layanan Digital Desa</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        body {
            background: #f8f9fa;
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5f 100%) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.9) !important;
            position: relative;
            padding: 0.5rem 0;
            margin: 0 0.5rem;
        }

        .nav-link:hover {
            color: #ffc107 !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #ffc107 !important;
            font-weight: 700;
            border-bottom: 3px solid #ffc107;
        }

        .btn-outline-light:hover {
            background: white;
            color: #2c5aa0 !important;
            border-color: white;
            transform: translateY(-2px);
        }

        .btn-light:hover {
            background: #ffc107 !important;
            border-color: #ffc107;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            /* Background image from project with a subtle dark overlay for contrast */
            background-image: linear-gradient(rgba(15, 58, 95, 0.55), rgba(15, 58, 95, 0.55)), url('{{ asset('images/bg-desa.jpg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,60 Q300,0 600,60 T1200,60 L1200,120 L0,120 Z" fill="rgba(255,255,255,0.1)"></path></svg>') repeat-x;
            opacity: 0.1;
            animation: wave 15s linear infinite;
        }

        @keyframes wave {
            0% { transform: translateX(0); }
            100% { transform: translateX(1200px); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-logo {
            width: 120px;
            height: 120px;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
            filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.2));
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-hero {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-hero-primary {
            background: #ffc107;
            color: #1e3a5f;
            border: none;
        }

        .btn-hero-primary:hover {
            background: #ffb300;
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3);
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-hero-secondary:hover {
            background: white;
            color: #2c5aa0;
            transform: translateY(-4px);
        }

        /* Kegiatan Section */
        .kegiatan-section {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #2c5aa0, #ffc107);
            border-radius: 2px;
        }

        .card-kegiatan {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .card-kegiatan:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(44, 90, 160, 0.2);
        }

        .card-kegiatan img {
            height: 220px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card-kegiatan:hover img {
            transform: scale(1.08);
        }

        .card-kegiatan .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .card-kegiatan .card-title {
            color: #1e3a5f;
            font-weight: 700;
            margin-bottom: 0.75rem;
            font-size: 1.2rem;
            line-height: 1.4;
            /* Line Clamp untuk Judul (Max 2 baris) */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-kegiatan .card-text {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
             /* Line Clamp untuk Deskripsi (Max 3 baris) */
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Wrapper tombol agar selalu di bawah */
        .card-footer-wrapper {
            margin-top: auto;
        }

        .card-date {
            color: #2c5aa0;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-read-more {
            background: linear-gradient(135deg, #2c5aa0, #1e3a5f);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-read-more:hover {
            background: linear-gradient(135deg, #1e3a5f, #2c5aa0);
            transform: translateX(5px);
            color: white;
            text-decoration: none;
        }

        .see-all-btn {
            background: linear-gradient(135deg, #ffc107, #ffb300);
            color: #1e3a5f;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 2rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .see-all-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.3);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5f 100%);
            color: white;
            padding: 2rem 0;
            margin-top: auto;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-logo {
                width: 100px;
                height: 100px;
            }

            .section-title {
                font-size: 2rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn-hero {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-4">
            {{-- Brand --}}
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('beranda') }}">
                <img src="{{ asset('images/logo-desa.png') }}" alt="Logo" width="40" height="40" class="me-2">
                Desa Wonokasian
            </a>

            {{-- Toggler --}}
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar Links --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" 
                           href="{{ route('beranda') }}">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </li>
                    @php
                        try {
                            $isLoggedIn = \Illuminate\Support\Facades\Auth::check();
                        } catch (\Exception $e) {
                            $isLoggedIn = false;
                        }
                    @endphp
                    @if($isLoggedIn)
                        <li class="nav-item">
                            @php $dashRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard'); @endphp
                            <a class="nav-link" href="{{ $dashRoute }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('surat') }}">
                                <i class="fas fa-file-alt me-2"></i>Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">
                                <i class="fas fa-user-circle me-2"></i>Profil Saya
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gallery.dashboard') }}">
                            <i class="fas fa-images me-2"></i>Galeri
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center ms-3 gap-2">
                    @if(session('success'))
                        <span id="nav-success-badge" class="badge bg-success text-white">{{ session('success') }}</span>
                        <script>
                            setTimeout(() => document.getElementById('nav-success-badge')?.remove(), 5000);
                        </script>
                    @endif

                    @php
                        try {
                            $currentUser = \Illuminate\Support\Facades\Auth::user();
                        } catch (\Exception $e) {
                            $currentUser = null;
                        }
                    @endphp

                    @if(!$currentUser)
                        <a href="{{ route('register.form') }}" class="btn btn-outline-light btn-sm">Register</a>
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a>
                    @else
                        <span class="text-white me-2">{{ $currentUser->name ?? 'Pengguna' }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="hero">
        <div class="hero-content container">
            <img src="{{ asset('images/logo-desa.png') }}" alt="Logo Desa" class="hero-logo" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 120 120%22><circle cx=%2260%22 cy=%2260%22 r=%2260%22 fill=%22%23ffc107%22/><text x=%2260%22 y=%2270%22 text-anchor=%22middle%22 font-size=%2240%22 font-weight=%22bold%22 fill=%22%231e3a5f%22>DW</text></svg>'">

            <h1>Selamat Datang di Desa Wonokasian</h1>
            <p>Layanan Digital Terpadu untuk Masyarakat</p>
            <p style="font-size: 1rem; opacity: 0.9;">Kecamatan Wonoayu, Kabupaten Sidoarjo, Jawa Timur</p>

            <div class="hero-buttons">
                @php
                    try {
                        $currentUser = \Illuminate\Support\Facades\Auth::user();
                    } catch (\Exception $e) {
                        $currentUser = null;
                    }
                @endphp

                @if(!$currentUser)
                    <a href="{{ route('register.form') }}" class="btn btn-hero btn-hero-primary">
                        <i class="fas fa-user-plus me-2"></i>Daftar
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-hero btn-hero-secondary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @else
                    @if(isset($currentUser->role) && $currentUser->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-hero btn-hero-primary">
                            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-hero btn-hero-secondary">
                            <i class="fas fa-users-cog me-2"></i>Kelola Pengguna
                        </a>
                    @else
                        <a href="{{ route('warga.dashboard') }}" class="btn btn-hero btn-hero-primary">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Warga
                        </a>
                        <a href="{{ route('surat.create') }}" class="btn btn-hero btn-hero-secondary">
                            <i class="fas fa-file-export me-2"></i>Ajukan Surat
                        </a>
                    @endif
                @endif

                <a href="{{ route('gallery.kegiatan') }}" class="btn btn-hero btn-hero-secondary">
                    <i class="fas fa-calendar-alt me-2"></i>Lihat Kegiatan
                </a>
            </div>
        </div>
    </section>

    {{-- KEGIATAN SECTION --}}
    <section class="kegiatan-section">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-md-6">
                    <h2 class="section-title">Kegiatan Desa</h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('gallery.kegiatan') }}" class="btn see-all-btn">
                        Lihat Semua Kegiatan <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            @php
                try {
                    $kegiatanTerbaru = \App\Models\Kegiatan::latest()->take(3)->get();
                } catch (\Exception $e) {
                    $kegiatanTerbaru = collect();
                }
            @endphp

            @if($kegiatanTerbaru->count() > 0)
                <div class="row g-4">
                    @foreach($kegiatanTerbaru as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card card-kegiatan">
                                @if($item->foto)
                                    <a href="{{ route('gallery.kegiatan.show', $item) }}" style="text-decoration: none; display: block; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}">
                                    </a>
                                @else
                                    <div style="height: 220px; background: linear-gradient(135deg, #2c5aa0, #1e3a5f); display: flex; align-items: center; justify-content: center; color: white;">
                                        <i class="fas fa-image" style="font-size: 4rem; opacity: 0.3;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <div class="card-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $item->tanggal ? $item->tanggal->locale('id')->format('d M Y') : '—' }}
                                    </div>
                                    <h5 class="card-title">
                                        <a href="{{ route('gallery.kegiatan.show', $item) }}" class="text-reset text-decoration-none">
                                            {{ $item->judul }}
                                        </a>
                                    </h5>
                                    <p class="card-text">{{ Str::limit($item->deskripsi, 100) }}</p>
                                    <div class="card-footer-wrapper">
                                        <a href="{{ route('gallery.kegiatan.show', $item) }}" class="btn-read-more">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="text-muted">Belum ada kegiatan desa. Silakan kembali lagi nanti.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>Desa Wonokasian
                    </h6>
                    <p class="text-white-50 small">
                        Kecamatan Wonoayu<br>
                        Kabupaten Sidoarjo<br>
                        Jawa Timur
                    </p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-link me-2"></i>Navigasi
                    </h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        @auth
                            <li><a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard') }}">Dashboard</a></li>
                        @endauth
                        <li><a href="{{ route('surat') }}">Surat</a></li>
                        <li><a href="{{ route('gallery.kegiatan') }}">Kegiatan</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </h6>
                    <p class="text-white-50 small">
                        <i class="fas fa-mobile-alt"></i> 085730151992<br>
                        <i class="fas fa-envelope"></i> info@desawonokasian.desa.id
                    </p>
                </div>
            </div>
            <hr class="bg-white-50">
            <div class="text-center">
                <p class="text-white-50 mb-0 small">
                    &copy; 2025 Desa Wonokasian. Semua hak dilindungi.
                </p>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
