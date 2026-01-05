@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
            <div class="card shadow-sm border-0">
                @if($kegiatan->foto)
                    <img src="{{ asset('storage/' . $kegiatan->foto) }}" class="card-img-top" alt="{{ $kegiatan->judul }}" style="height:300px;object-fit:cover;">
                @endif
                <div class="card-body">
                    <h2 class="fw-bold">{{ $kegiatan->judul }}</h2>
                    <p class="text-muted small">{{ $kegiatan->tanggal ? $kegiatan->tanggal->format('d M Y') : '' }}</p>
                    <div class="mt-3">{!! nl2br(e($kegiatan->deskripsi)) !!}</div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary">← Kembali ke Kegiatan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
