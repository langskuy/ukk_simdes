<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo-desa.png') }}" alt="Logo" width="40" height="40" class="me-2">
            Desa Wonokasian
        </a>

        {{-- Toggler --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Links --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @php
                    $isAuthRoute = request()->routeIs('login') || request()->routeIs('register.form');
                @endphp
                @unless($isAuthRoute)
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('desa.profile') ? 'active' : '' }}"
                            href="{{ route('desa.profile') }}">Profil Desa</a>
                    </li>
                @endunless

                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('surat.*') ? 'active' : '' }}"
                            href="{{ route('surat') }}">Surat Desa</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}"
                            href="{{ route('pengaduan.create') }}">Pengaduan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('gallery.*') ? 'active' : '' }}"
                            href="{{ route('gallery.dashboard') }}">Galeri</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold {{ request()->routeIs('profile') ? 'active' : '' }}"
                            href="{{ route('profile') }}">Profil Saya</a>
                    </li>

                    @if(!auth()->check() || auth()->user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                                href="#" data-bs-toggle="dropdown">
                                Admin Panel
                            </a>
                            <ul class="dropdown-menu shadow border-0 rounded-3">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Kelola Pengguna</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pengaduan.index') }}">Kelola Pengaduan</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.kegiatan.index') }}">Kelola Kegiatan</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.desa.profile') }}">Kelola Profil Desa</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.surat.index') }}">Kelola Surat</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            {{-- Auth Buttons / User Menu --}}
            <div class="ms-lg-3 mt-2 mt-lg-0 d-flex align-items-center">
                @guest
                    <a href="{{ route('register.form') }}" class="btn btn-outline-primary me-2 fw-semibold">
                        Register
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-primary fw-semibold">
                        Login
                    </a>
                @else
                    @php $dash = auth()->user()->role === 'admin' ? route('admin.dashboard') : route('warga.dashboard'); @endphp
                    <a href="{{ $dash }}" class="btn btn-outline-primary me-2 d-none d-sm-inline">Dashboard</a>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userMenuDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3"
                            aria-labelledby="userMenuDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ $dash }}">Dashboard</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">Profil Saya</a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{-- Optional Custom Styles --}}
<style>
    .navbar-nav .nav-link {
        transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #0d6efd;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>