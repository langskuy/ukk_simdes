@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid">
        {{-- Welcome Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white p-4 rounded-4 shadow-sm border-0 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold mb-1">Selamat Datang Back, Admin 👋</h4>
                        <p class="text-muted mb-0 small">Berikut adalah ringkasan operasional desa hari ini,
                            {{ now()->format('d F Y') }}
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-clock"></i> <span id="live-clock">{{ now()->format('H:i:s') }}</span> WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-megaphone fs-4 text-primary"></i>
                            </div>
                            <span class="badge bg-danger rounded-pill h-fit">{{ $pengaduan_new }} Baru</span>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">Pengaduan</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $pengaduan_count }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-calendar-event fs-4 text-danger"></i>
                            </div>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">Kegiatan Desa</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $kegiatan_count }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-file-earmark-text fs-4 text-info"></i>
                            </div>
                            <span class="badge bg-warning text-dark rounded-pill h-fit">{{ $surat_new }} Proses</span>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">Permohonan Surat</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $surat_count }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-people fs-4 text-warning"></i>
                            </div>
                        </div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1">Warga Terdaftar</h6>
                        <h2 class="fw-bold mb-0 text-dark">{{ $user_count }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Sections --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                {{-- Ringkasan Aktivitas Card --}}
                <div class="card border-0 rounded-4 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="fw-bold mb-0"><i class="bi bi-graph-up me-2 text-primary"></i>Ringkasan Aktivitas</h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-4 rounded-4 border-start border-danger border-5 bg-danger bg-opacity-10">
                                    <h6 class="text-danger fw-bold mb-1">Pengaduan Warga</h6>
                                    <h1 class="display-5 fw-bold mb-0 text-dark">{{ $pengaduan_new }}</h1>
                                    <p class="mb-0 text-muted mt-2 small">Laporan yang perlu ditanggapi.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 rounded-4 border-start border-primary border-5 bg-primary bg-opacity-10">
                                    <h6 class="text-primary fw-bold mb-1">Permohonan Surat</h6>
                                    <h1 class="display-5 fw-bold mb-0 text-dark">{{ $surat_new }}</h1>
                                    <p class="mb-0 text-muted mt-2 small">Berkas yang perlu diperiksa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Log Aktivitas Card (Separated) --}}
                <div class="card border-0 rounded-4 shadow-sm">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-clock-history me-2 text-success"></i>Log Aktivitas Terbaru
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill ms-2 small">Live</span>
                        </h5>
                    </div>
                    <div class="card-body p-4 activity-log-container">
                        <div class="list-group list-group-flush" id="activity-log-list">
                            @forelse($activities as $activity)
                                <div class="list-group-item bg-transparent border-0 px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($activity->activity_type === 'login')
                                                <div class="bg-success bg-opacity-10 text-success rounded-circle p-2">
                                                    <i class="bi bi-box-arrow-in-right"></i>
                                                </div>
                                            @elseif($activity->activity_type === 'logout')
                                                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-2">
                                                    <i class="bi bi-box-arrow-right"></i>
                                                </div>
                                            @elseif($activity->activity_type === 'permohonan')
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </div>
                                            @elseif($activity->activity_type === 'laporan')
                                                <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2">
                                                    <i class="bi bi-megaphone"></i>
                                                </div>
                                            @else
                                                <div class="bg-info bg-opacity-10 text-info rounded-circle p-2">
                                                    <i class="bi bi-info-circle"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <p class="mb-0 small fw-bold text-dark">{{ $activity->user?->name ?? 'Sistem' }}</p>
                                            <p class="mb-0 x-small text-muted">{{ $activity->description }}</p>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="x-small text-muted">{{ $activity->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2 mb-0 small">Belum ada aktivitas tercatat.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 rounded-4 shadow-sm">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="fw-bold mb-0"><i class="bi bi-lightning-charge me-2 text-warning"></i>Aksi Cepat</h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.kegiatan.create') }}"
                                class="btn btn-light border-0 text-start py-3 px-3 rounded-3 shadow-sm-hover mb-2">
                                <i class="bi bi-plus-circle-fill text-primary me-2"></i> Buat Kegiatan Baru
                            </a>
                            <a href="{{ route('admin.surat.index') }}"
                                class="btn btn-light border-0 text-start py-3 px-3 rounded-3 shadow-sm-hover mb-2">
                                <i class="bi bi-file-earmark-check-fill text-success me-2"></i> Verifikasi Surat
                            </a>
                            <a href="{{ route('admin.pengaduan.index') }}"
                                class="btn btn-light border-0 text-start py-3 px-3 rounded-3 shadow-sm-hover mb-2">
                                <i class="bi bi-chat-left-dots-fill text-danger me-2"></i> Cek Pengaduan
                            </a>
                            <a href="{{ route('admin.desa.profile') }}"
                                class="btn btn-light border-0 text-start py-3 px-3 rounded-3 shadow-sm-hover">
                                <i class="bi bi-gear-fill text-muted me-2"></i> Pengaturan Desa
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tip Alert --}}
                <div class="alert alert-light border-0 rounded-4 shadow-sm mt-4 d-flex align-items-center p-4">
                    <i class="bi bi-lightbulb-fill text-warning fs-3 me-3"></i>
                    <div class="small">
                        <strong>Tips Admin:</strong> Dashboard ini sekarang terhubung ke Firebase untuk pemantauan data
                        secara realtime.
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="py-4 text-center text-muted">
            <p class="small mb-0">&copy; {{ date('Y') }} Wonokasian Admin Panel | Crafted with excellence for better
                governance.</p>
        </div>
    </div>

    <style>
        .shadow-sm-hover {
            transition: all 0.2s ease;
        }

        .shadow-sm-hover:hover {
            background-color: #f8f9fa !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transform: translateX(5px);
        }

        .h-fit {
            height: fit-content;
        }

        .x-small {
            font-size: 0.75rem;
        }

        .list-group-item {
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: rgba(0, 0, 0, 0.02) !important;
        }

        .animate-pulse {
            animation: pulse-bg 2s ease-out;
        }

        @keyframes pulse-bg {
            0% {
                background-color: rgba(67, 97, 238, 0.1);
            }

            100% {
                background-color: transparent;
            }
        }

        /* Activity Log Container - Scrollable */
        .activity-log-container {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Custom Scrollbar untuk Activity Log */
        .activity-log-container::-webkit-scrollbar {
            width: 8px;
        }

        .activity-log-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .activity-log-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .activity-log-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endsection

@push('scripts')
    {{-- Firebase SDK (Legacy Compat for easier integration) --}}
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-database-compat.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyBDaghYOtdprHbBcwmXv412KYNZzVmtybg",
            authDomain: "simdes-17.firebaseapp.com",
            databaseURL: "https://simdes-17-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "simdes-17",
            storageBucket: "simdes-17.firebasestorage.app",
            messagingSenderId: "465697348108",
            appId: "1:465697348108:web:0981d5b174602622846c29"
        };

        // Initialize Firebase
        if (firebaseConfig.apiKey !== "YOUR_API_KEY") {
            firebase.initializeApp(firebaseConfig);
            const database = firebase.database();

            // 1. Listen for new activities
            database.ref('activities').limitToLast(1).on('child_added', (snapshot) => {
                const data = snapshot.val();
                if (!data) return;

                const list = document.getElementById('activity-log-list');
                if (!list) return;

                const item = document.createElement('div');
                item.className = 'list-group-item bg-transparent border-0 px-0 py-2 animate-pulse';

                let iconClass = 'bi-info-circle';
                let bgClass = 'bg-info';
                let textClass = 'text-info';

                const typeLower = (data.type || '').toLowerCase();
                if (typeLower === 'login') {
                    iconClass = 'bi-box-arrow-in-right'; bgClass = 'bg-success'; textClass = 'text-success';
                } else if (typeLower === 'logout') {
                    iconClass = 'bi-box-arrow-right'; bgClass = 'bg-secondary'; textClass = 'text-secondary';
                } else if (typeLower === 'permohonan') {
                    iconClass = 'bi-file-earmark-text'; bgClass = 'bg-primary'; textClass = 'text-primary';
                } else if (typeLower === 'laporan') {
                    iconClass = 'bi-megaphone'; bgClass = 'bg-danger'; textClass = 'text-danger';
                }

                item.innerHTML = `
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="${bgClass} bg-opacity-10 ${textClass} rounded-circle p-2">
                                                <i class="bi ${iconClass}"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0 small fw-bold text-dark">${data.userName || 'Sistem'}</p>
                                            <p class="mb-0 x-small text-muted">${data.description || ''}</p>
                                        </div>
                                        <div class="ms-auto">
                                            <span class="x-small text-muted">Baru saja</span>
                                        </div>
                                    </div>
                                `;

                const noActivity = list.querySelector('.text-center');
                if (noActivity) noActivity.remove();

                list.prepend(item);
                if (list.children.length > 10) list.lastElementChild.remove();
            });

            // 2. Listen for counters to update sidebar & cards
            database.ref('counters/surat_new').on('value', (snapshot) => {
                const count = snapshot.val();
                if (count === null) return;

                const badge = document.querySelector('a[href*="admin/surat"] .badge');
                if (badge) badge.innerText = count;

                const labels = Array.from(document.querySelectorAll('h6'));
                const suratCardHead = labels.find(el => el.textContent.includes('Permohonan Surat'));
                if (suratCardHead) {
                    const h2 = suratCardHead.nextElementSibling;
                    if (h2) h2.innerText = count;
                }
            });

            database.ref('counters/pengaduan_new').on('value', (snapshot) => {
                const count = snapshot.val();
                if (count === null) return;

                const badge = document.querySelector('a[href*="admin/pengaduan"] .badge');
                if (badge) badge.innerText = count;

                const labels = Array.from(document.querySelectorAll('h6'));
                const pengaduanCardHead = labels.find(el => el.textContent.includes('Pengaduan'));
                if (pengaduanCardHead) {
                    const h2 = pengaduanCardHead.nextElementSibling;
                    if (h2) h2.innerText = count;
                }
            });
        }
    </script>

    {{-- Live Clock Script --}}
    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
            const clockElement = document.getElementById('live-clock');
            if (clockElement) {
                clockElement.textContent = timeString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock(); // Run immediately
    </script>
@endpush