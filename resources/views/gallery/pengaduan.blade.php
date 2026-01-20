@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="mb-5">
            <h1 class="text-4xl font-bold mb-2">Daftar Pengaduan</h1>
            <p class="text-gray-600">Pengaduan dari warga desa yang sedang diproses atau selesai</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6 border-b">
            <div class="flex gap-4">
                <a href="{{ route('gallery.dashboard') }}"
                    class="pb-3 px-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 transition">
                    Dashboard
                </a>
                <a href="{{ route('gallery.pengaduan') }}"
                    class="pb-3 px-2 border-b-2 border-blue-500 text-blue-600 font-semibold">
                    Pengaduan
                </a>
                <a href="{{ route('gallery.kegiatan') }}"
                    class="pb-3 px-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 transition">
                    Kegiatan
                </a>
            </div>
        </div>

        <!-- Filter Status -->
        <div class="mb-6 flex gap-2 flex-wrap">
            <a href="{{ route('gallery.pengaduan') }}"
                class="px-4 py-2 rounded {{ request('status') === null ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua
            </a>
            <a href="{{ route('gallery.pengaduan', ['status' => 'baru']) }}"
                class="px-4 py-2 rounded {{ request('status') === 'baru' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Belum Diproses
            </a>
            <a href="{{ route('gallery.pengaduan', ['status' => 'diproses']) }}"
                class="px-4 py-2 rounded {{ request('status') === 'diproses' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Diproses
            </a>
            <a href="{{ route('gallery.pengaduan', ['status' => 'selesai']) }}"
                class="px-4 py-2 rounded {{ request('status') === 'selesai' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Selesai
            </a>
        </div>

        <!-- List -->
        @if($pengaduans->count() > 0)
            <div class="space-y-4">
                @foreach($pengaduans as $pengaduan)
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition p-5 border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $pengaduan->judul }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Oleh: <strong>{{ $pengaduan->nama_pelapor }}</strong> •
                                    {{ $pengaduan->created_at->locale('id')->diffForHumans() }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($pengaduan->status === 'baru')
                                            bg-indigo-200 text-indigo-800
                                        @elseif($pengaduan->status === 'diproses')
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

                        <p class="text-gray-700 mb-4 leading-relaxed">
                            {{ Str::limit($pengaduan->isi, 150) }}
                        </p>

                        <!-- Lampiran & Action -->
                        <div class="flex justify-between items-center pt-3 border-t">
                            <div class="text-sm">
                                @if($pengaduan->lampiran)
                                    <a href="{{ asset('storage/' . $pengaduan->lampiran) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                        📎 Lihat Lampiran
                                    </a>
                                @else
                                    <span class="text-gray-500">Tidak ada lampiran</span>
                                @endif
                            </div>
                            <a href="{{ route('gallery.pengaduan.show', $pengaduan->id) }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm font-semibold">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $pengaduans->links() }}
            </div>
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-12 text-center">
                <p class="text-gray-600 text-lg">Tidak ada pengaduan untuk ditampilkan</p>
            </div>
        @endif
    </div>
@endsection