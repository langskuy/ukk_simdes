@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-5">
        <h1 class="text-4xl font-bold mb-2">Galeri Desa</h1>
        <p class="text-gray-600">Lihat pengaduan dan kegiatan desa terbaru</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 border-b">
        <div class="flex gap-4">
            <a href="{{ route('gallery.dashboard') }}" class="pb-3 px-2 border-b-2 border-blue-500 text-blue-600 font-semibold">
                Dashboard
            </a>
            <a href="{{ route('gallery.pengaduan') }}" class="pb-3 px-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 transition">
                Pengaduan
            </a>
            <a href="{{ route('gallery.kegiatan') }}" class="pb-3 px-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 transition">
                Kegiatan
            </a>
        </div>
    </div>

    <!-- Pengaduan Section -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Pengaduan Terbaru</h2>
            <a href="{{ route('gallery.pengaduan') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua →</a>
        </div>

        @if($recentPengaduans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentPengaduans as $pengaduan)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <!-- Status Badge -->
                        <div class="px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200">
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

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                {{ $pengaduan->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ $pengaduan->isi }}
                            </p>
                            <div class="text-xs text-gray-500 mb-4">
                                <div>Pelapor: {{ $pengaduan->nama_pelapor }}</div>
                                <div>{{ $pengaduan->created_at->locale('id')->diffForHumans() }}</div>
                            </div>

                            <!-- Lampiran Badge -->
                            @if($pengaduan->lampiran)
                                <div class="mb-4">
                                    <a href="{{ asset($pengaduan->lampiran) }}" target="_blank" class="text-blue-600 text-sm hover:text-blue-800">
                                        📎 Lihat Lampiran
                                    </a>
                                </div>
                            @endif

                            <!-- View Button -->
                            <a href="{{ route('gallery.pengaduan.show', $pengaduan->id) }}" class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition text-sm font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center text-gray-600">
                <p>Belum ada pengaduan yang ditampilkan</p>
            </div>
        @endif
    </div>

    <!-- Kegiatan Section -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Kegiatan Terbaru</h2>
            <a href="{{ route('gallery.kegiatan') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua →</a>
        </div>

        @if($recentKegiatans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentKegiatans as $kegiatan)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <!-- Foto -->
                        @if($kegiatan->foto && file_exists(public_path($kegiatan->foto)))
                            <div class="h-48 overflow-hidden bg-gray-200">
                                <img src="{{ asset($kegiatan->foto) }}" alt="{{ $kegiatan->judul }}" class="w-full h-full object-cover hover:scale-105 transition">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                <span class="text-gray-500 text-3xl">📷</span>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                {{ $kegiatan->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ $kegiatan->deskripsi }}
                            </p>
                            <div class="text-xs text-gray-500 mb-4">
                                <div>📅 {{ $kegiatan->tanggal->locale('id')->isoFormat('D MMMM Y') }}</div>
                            </div>

                            <!-- View Button -->
                            <a href="{{ route('gallery.kegiatan.show', $kegiatan->id) }}" class="block text-center bg-green-600 text-white py-2 rounded hover:bg-green-700 transition text-sm font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center text-gray-600">
                <p>Belum ada kegiatan yang ditampilkan</p>
            </div>
        @endif
    </div>
</div>
@endsection
