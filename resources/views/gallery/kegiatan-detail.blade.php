@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('gallery.kegiatan') }}" class="text-blue-600 hover:text-blue-800 font-semibold">← Kembali ke Galeri Kegiatan</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Foto -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                @if($kegiatan->foto && file_exists(public_path('storage/' . $kegiatan->foto)))
                    <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="{{ $kegiatan->judul }}" class="w-full h-auto max-h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                        <span class="text-gray-500 text-6xl">📷</span>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="bg-white rounded-lg shadow p-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $kegiatan->judul }}</h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap gap-4 mb-6 pb-6 border-b text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">📅</span>
                        <span><strong>Tanggal:</strong> {{ $kegiatan->tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="prose prose-sm max-w-none">
                    <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi Kegiatan</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap mb-4">
                        {{ $kegiatan->deskripsi }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Info Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200 sticky top-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">ℹ️ Informasi Kegiatan</h3>
                
                <div class="space-y-4 text-sm text-gray-700">
                    <div>
                        <span class="block text-xs uppercase tracking-wide text-gray-600 font-semibold mb-1">Tanggal Pelaksanaan</span>
                        <p class="text-lg font-bold text-green-600">
                            {{ $kegiatan->tanggal->locale('id')->isoFormat('D MMMM Y') }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-green-200">
                        <p class="text-xs text-gray-600">
                            📝 ID Kegiatan: <strong>#{{ $kegiatan->id }}</strong>
                        </p>
                        <p class="text-xs text-gray-600 mt-2">
                            ⏱️ Diposting: {{ $kegiatan->created_at->locale('id')->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Share Card (Optional) -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🔗 Bagikan</h3>
                <div class="space-y-2">
                    <button onclick="copyToClipboard('{{ url()->current() }}')" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm font-semibold">
                        📋 Salin Link
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Kegiatan -->
    @php
        $relatedKegiatans = \App\Models\Kegiatan::where('id', '<>', $kegiatan->id)->latest()->take(3)->get();
    @endphp

    @if($relatedKegiatans->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kegiatan Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedKegiatans as $related)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <!-- Foto -->
                        <div class="h-40 overflow-hidden bg-gray-200">
                            @if($related->foto && file_exists(public_path('storage/' . $related->foto)))
                                <img src="{{ asset('storage/' . $related->foto) }}" alt="{{ $related->judul }}" class="w-full h-full object-cover hover:scale-105 transition">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-300 to-gray-400">
                                    <span class="text-gray-500 text-3xl">📷</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <p class="text-xs text-blue-600 font-semibold mb-1 uppercase">
                                {{ $related->tanggal->locale('id')->isoFormat('D MMMM Y') }}
                            </p>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                {{ $related->judul }}
                            </h3>
                            <a href="{{ route('gallery.kegiatan.show', $related->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Link telah disalin ke clipboard!');
        });
    }
</script>
@endsection
