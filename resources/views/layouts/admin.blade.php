<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Desa Wonokasian</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fe;
            overflow-x: hidden;
        }

        :root {
            --sidebar-width: 260px;
            --admin-blue: #4361ee;
            --admin-dark: #1e1e2d;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--admin-dark);
            color: #a2a3b7;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            /* Flex Layout for Responsive Height */
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            flex-shrink: 0; /* Header stays fixed */
        }

        .sidebar-brand {
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            list-style: none;
            margin: 0;
            /* Scrollable Area */
            flex-grow: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .menu-item {
            padding: 0.2rem 1.5rem;
        }

        .menu-link {
            color: #a2a3b7;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            gap: 12px;
            font-weight: 500;
        }

        .menu-link:hover,
        .menu-link.active {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .menu-link.active {
            background: var(--admin-blue);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .menu-link i {
            font-size: 1.2rem;
        }

        .menu-label {
            padding: 1.5rem 1.5rem 0.5rem;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #565674;
        }

        /* Main Content */
        #content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            margin: -2rem -2rem 2rem -2rem;
            border-bottom: 1px solid #ebedf3;
            justify-content: space-between;
        }

        /* Responsive */
        @media (max-width: 992px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .btn-admin-logout {
            color: #f1416c;
            font-weight: 600;
        }

        .btn-admin-logout:hover {
            background: rgba(241, 65, 108, 0.1);
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Sidebar --}}
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="bg-primary rounded-3 p-2 d-flex align-items-center justify-content-center">
                    <i class="bi bi-shield-check text-white"></i>
                </div>
                <span>SIMDES ADMIN</span>
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-label">Layanan Desa</li>

            <li class="menu-item">
                <a href="{{ route('admin.surat.index') }}"
                    class="menu-link {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope-paper"></i>
                    <span>Permohonan Surat</span>
                    @if(isset($pendingSuratCount) && $pendingSuratCount > 0)
                        <span class="badge bg-danger ms-auto rounded-pill">{{ $pendingSuratCount }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.pengaduan.index') }}"
                    class="menu-link {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone"></i>
                    <span>Pengaduan Warga</span>
                    @if(isset($pendingPengaduanCount) && $pendingPengaduanCount > 0)
                        <span class="badge bg-danger ms-auto rounded-pill">{{ $pendingPengaduanCount }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-label">Informasi & Data</li>

            <li class="menu-item">
                <a href="{{ route('admin.kegiatan.index') }}"
                    class="menu-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i>
                    <span>Kegiatan Desa</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.penduduk.index') }}"
                    class="menu-link {{ request()->routeIs('admin.penduduk.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Data Warga</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.keuangan.index') }}"
                    class="menu-link {{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Keuangan Desa</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.users.index') }}"
                    class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Manajemen Akun</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('desa.profile') }}"
                    class="menu-link {{ request()->routeIs('desa.profile') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Profil Desa</span>
                </a>
            </li>

            @auth
                <li class="menu-label">Akun</li>
                <li class="menu-item">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="menu-link btn-admin-logout w-100 border-0 bg-transparent text-start">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar Panel</span>
                        </button>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>

    {{-- Main Content --}}
    <div id="content">
        <div class="top-bar">
            <div>
                <button class="btn d-lg-none" onclick="document.getElementById('sidebar').classList.toggle('active')">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <h5 class="mb-0 fw-bold d-none d-md-inline-block">
                    @yield('title', 'Admin Panel')
                </h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 fw-bold small text-dark">
                        {{ auth()->check() ? auth()->user()->name : 'Administrator' }}</p>
                    <p class="mb-0 text-muted small" style="font-size: 0.75rem;">Administrator</p>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-person text-white fs-5"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2"
                        aria-labelledby="dropdownUser1">
                        <li>
                            <div class="dropdown-header text-start">
                                <span
                                    class="fw-bold d-block">{{ auth()->check() ? auth()->user()->name : 'Administrator' }}</span>
                                <small class="text-muted">Administrator</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @auth
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item text-danger fw-semibold d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>