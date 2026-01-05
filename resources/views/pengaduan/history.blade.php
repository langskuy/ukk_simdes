@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-secondary text-white fw-bold">
                    📜 Riwayat Pengaduan Saya
                </div>
                <div class="card-body">
                    @if($pengaduans->isEmpty())
                        <div class="alert alert-info">Belum ada pengaduan. <a href="{{ route('pengaduan.create') }}">Ajukan pengaduan sekarang</a>.</div>
                    @else
                        <div class="list-group">
                            @foreach($pengaduans as $p)
                                <div class="list-group-item list-group-item-action mb-2">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $p->judul }}</h5>
                                        <small>{{ $p->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($p->isi, 200) }}</p>
                                    <small>Status: <strong>{{ ucfirst($p->status) }}</strong></small>
                                    @if($p->lampiran)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $p->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Lampiran</a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
