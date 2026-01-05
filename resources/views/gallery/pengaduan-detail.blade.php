@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('gallery.pengaduan') }}" class="text-blue-600 hover:text-blue-800">← Kembali ke Daftar Pengaduan</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $pengaduan->judul }}</h1>
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                @if($pengaduan->status === 'diproses')
                                    bg-yellow-200 text-yellow-800
                                @elseif($pengaduan->status === 'selesai')
                                    bg-green-200 text-green-800
                                @else
                                    bg-gray-200 text-gray-800
                                @endif
                            ">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Meta Info -->
                    <div class="bg-gray-50 rounded p-4 text-sm text-gray-600 space-y-2">
                        <div><strong>Pelapor:</strong> {{ $pengaduan->nama_pelapor }}</div>
                        <div><strong>NIK:</strong> {{ $pengaduan->nik ?? 'Tidak ada' }}</div>
                        <div><strong>Nomor HP:</strong> {{ $pengaduan->no_hp }}</div>
                        <div><strong>Tanggal Pengaduan:</strong> {{ $pengaduan->created_at->locale('id')->isoFormat('D MMMM Y pukul HH:mm') }}</div>
                    </div>
                </div>

                <!-- Content -->
                <div class="mb-8 py-6 border-t border-b">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Isi Pengaduan</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $pengaduan->isi }}
                    </p>
                </div>

                <!-- Lampiran -->
                @if($pengaduan->lampiran)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">📎 Lampiran</h2>
                        
                        @php
                            $fileExt = strtolower(pathinfo($pengaduan->lampiran, PATHINFO_EXTENSION));
                            $imageMimes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                        @endphp

                        @if(in_array($fileExt, $imageMimes))
                            <div class="mb-4">
                                <img src="{{ asset($pengaduan->lampiran) }}" alt="Lampiran" class="max-w-full max-h-96 rounded shadow">
                            </div>
                        @endif

                        <a href="{{ asset($pengaduan->lampiran) }}" download class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">
                            📥 Download Lampiran
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Status Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 mb-6 border border-blue-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pengaduan</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-xs uppercase tracking-wide text-gray-600">Status Saat Ini</span>
                        <p class="text-lg font-bold text-blue-600">
                            @switch($pengaduan->status)
                                @case('baru')
                                    🆕 Baru
                                    @break
                                @case('diproses')
                                    ⏳ Sedang Diproses
                                    @break
                                @case('selesai')
                                    ✅ Selesai
                                    @break
                                @case('ditolak')
                                    ❌ Ditolak
                                    @break
                                @default
                                    {{ ucfirst($pengaduan->status) }}
                            @endswitch
                        </p>
                    </div>
                    <div class="text-sm text-gray-600">
                        Diperbarui: {{ $pengaduan->updated_at->locale('id')->diffForHumans() }}
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">ℹ️ Informasi</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Pengaduan Anda sedang ditangani oleh tim desa. Kami akan segera memproses dan memberikan respons sesuai dengan prosedur yang berlaku.
                </p>
                <div class="mt-4 pt-4 border-t">
                    <p class="text-xs text-gray-500">
                        ID Pengaduan: <strong>#{{ $pengaduan->id }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
