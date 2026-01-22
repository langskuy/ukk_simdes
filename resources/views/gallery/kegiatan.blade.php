@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="mb-5">
            <h1 class="text-4xl font-bold mb-2">Galeri Kegiatan</h1>
            <p class="text-gray-600">Dokumentasi kegiatan-kegiatan desa terbaru</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6 border-b">
            <div class="flex gap-4">
                <a href="{{ route('gallery.dashboard') }}"
                    class="pb-3 px-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 transition">
                    Dashboard
                </a>
                <a href="{{ route('gallery.pengaduan') }}"
                    class="pb-3 px-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 transition">
                    Pengaduan
                </a>
                <a href="{{ route('gallery.kegiatan') }}"
                    class="pb-3 px-2 border-b-2 border-blue-500 text-blue-600 font-semibold">
                    Kegiatan
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        @if($kegiatans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kegiatans as $kegiatan)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden group">
                        <!-- Foto -->
                        <div class="h-56 overflow-hidden bg-gray-200">
                            @if($kegiatan->foto)
                                <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="{{ $kegiatan->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                                    <span class="text-gray-500 text-5xl">📷</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <!-- Tanggal -->
                            <div class="text-xs text-blue-600 font-semibold mb-2 uppercase tracking-wide">
                                📅 {{ $kegiatan->tanggal->locale('id')->isoFormat('D MMMM Y') }}
                            </div>

                            <!-- Judul -->
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                {{ $kegiatan->judul }}
                            </h3>

                            <!-- Deskripsi -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $kegiatan->deskripsi }}
                            </p>

                            <!-- Button -->
                            <a href="{{ route('gallery.kegiatan.show', $kegiatan->id) }}"
                                class="block text-center w-full bg-green-600 text-white py-2 rounded font-semibold hover:bg-green-700 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $kegiatans->links() }}
            </div>
        @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-12 text-center">
                <p class="text-gray-600 text-lg">Belum ada kegiatan untuk ditampilkan</p>
            </div>
        @endif
    </div>
@endsection