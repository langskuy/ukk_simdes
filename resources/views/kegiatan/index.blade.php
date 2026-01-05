@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Kegiatan Desa</h2>
        <a href="{{ route('beranda') }}" class="btn btn-outline-secondary">← Kembali</a>
    </div>

    @if($kegiatans->count() > 0)
        <div class="row g-4">
            @foreach($kegiatans as $item)
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if($item->foto)
                            <a href="{{ route('kegiatan.show', $item) }}">
                                <img src="{{ asset('storage/' . $item->foto) }}" class="card-img-top" alt="{{ $item->judul }}" style="height:180px;object-fit:cover;">
                            </a>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('kegiatan.show', $item) }}">{{ $item->judul }}</a></h5>
                            <p class="text-muted small">{{ $item->tanggal ? $item->tanggal->format('d M Y') : '' }}</p>
                            <p class="mb-0">{{ Str::limit($item->deskripsi, 120) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ route('kegiatan.show', $item) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $kegiatans->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <p class="text-muted">Belum ada kegiatan.</p>
        </div>
    @endif
</div>
@endsection
