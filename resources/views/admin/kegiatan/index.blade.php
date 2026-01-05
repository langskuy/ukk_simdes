@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">📅 Kelola Kegiatan</h3>
        <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-success fw-semibold">➕ Tambah Kegiatan</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-info text-white fw-bold">Daftar Kegiatan</div>
        <div class="card-body">
            @if ($kegiatans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kegiatans as $kegiatan)
                                <tr>
                                    <td>{{ ($kegiatans->currentPage() - 1) * $kegiatans->perPage() + $loop->iteration }}</td>
                                    <td><strong>{{ $kegiatan->judul }}</strong></td>
                                    @php
                                        $kegTanggal = $kegiatan->tanggal;
                                        if ($kegTanggal) {
                                            if (! $kegTanggal instanceof \Illuminate\Support\Carbon) {
                                                try {
                                                    $kegTanggal = \Carbon\Carbon::parse($kegTanggal);
                                                } catch (\Exception $e) {
                                                    $kegTanggal = null;
                                                }
                                            }
                                        }
                                    @endphp
                                    <td>{{ $kegTanggal ? $kegTanggal->format('d/m/Y') : '—' }}</td>
                                    <td>{{ $kegiatan->created_at->diffForHumans() }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.kegiatan.edit', $kegiatan) }}" class="btn btn-sm btn-warning" title="Edit">✏️</a>
                                        <form action="{{ route('admin.kegiatan.destroy', $kegiatan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kegiatan ini?')" title="Hapus">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $kegiatans->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted fs-5">Belum ada kegiatan yang dibuat.</p>
                    <a href="{{ route('admin.kegiatan.create') }}" class="btn btn-success">➕ Buat Kegiatan Pertama</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
