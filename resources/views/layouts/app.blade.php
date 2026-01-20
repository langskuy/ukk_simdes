<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Wonokasian - Layanan Digital Desa</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Tailwind CSS (CDN for Development) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- View-specific styles --}}
    @stack('styles')

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: #f8f9fa;
            color: #333;
        }

        main {
            flex: 1;
        }

        .navbar {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a5f 100%) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
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

        /* Content Styling */
        main {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(44, 90, 160, 0.15);
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, #2c5aa0, #1e3a5f);
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1e3a5f, #2c5aa0);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 90, 160, 0.3);
        }

        .btn-success {
            background: #10b981;
            border: none;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #ef4444;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1.2rem;
            font-weight: 500;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        /* Form Styling */
        .form-control,
        .form-select {
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2c5aa0;
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #1e3a5f;
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            main {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Bottom Navbar for Mobile --}}
    @auth
        <div class="d-lg-none fixed-bottom bg-white border-top shadow-lg py-2 dashboard-nav">
            <div class="container">
                <div class="row text-center align-items-center">
                    <div class="col">
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard') }}"
                            class="text-decoration-none {{ request()->routeIs('*.dashboard') ? 'text-primary' : 'text-muted' }}">
                            <i class="bi bi-grid-fill fs-4 d-block"></i>
                            <span class="small">Dashboard</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('surat') }}"
                            class="text-decoration-none {{ request()->routeIs('surat*') ? 'text-primary' : 'text-muted' }}">
                            <i class="bi bi-file-earmark-text-fill fs-4 d-block"></i>
                            <span class="small">Surat</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('pengaduan.create') }}"
                            class="text-decoration-none {{ request()->routeIs('pengaduan*') ? 'text-primary' : 'text-muted' }}">
                            <i class="bi bi-megaphone-fill fs-4 d-block"></i>
                            <span class="small">Lapor</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('profile') }}"
                            class="text-decoration-none {{ request()->routeIs('profile') ? 'text-primary' : 'text-muted' }}">
                            <i class="bi bi-person-fill fs-4 d-block"></i>
                            <span class="small">Profil</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <style>
            body {
                padding-bottom: 70px;
            }

            @media (min-width: 992px) {
                body {
                    padding-bottom: 0;
                }
            }
        </style>
    @endauth

    {{-- Main Content --}}
    <main class="flex-grow-1">
        @auth
            @unless(request()->routeIs('*.dashboard'))
                <div class="container mt-4">
                    <div class="d-flex justify-content-end mb-3">
                        @php $dashRoute = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard'); @endphp
                        <a href="{{ $dashRoute }}" class="btn btn-outline-primary shadow-sm rounded-pill px-4 fw-bold">
                            <i class="bi bi-grid-fill me-2"></i>Dashboard
                            {{ auth()->user()->role === 'admin' ? 'Admin' : 'Warga' }}
                        </a>
                    </div>
                </div>
            @endunless
        @endauth
        @yield('content')
    </main>

    {{-- Footer --}}
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
                            <li><a
                                    href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard') }}">Dashboard</a>
                            </li>
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

    {{-- View-specific scripts --}}
    @stack('scripts')
</body>

</html>