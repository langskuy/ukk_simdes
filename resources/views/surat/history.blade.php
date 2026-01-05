@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">📋 Riwayat Pengajuan Surat Saya</h2>
                <a href="{{ route('surat') }}" class="btn btn-primary fw-semibold">➕ Ajukan Surat Baru</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($surats->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis Surat</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Selesai</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surats as $surat)
                                <tr>
                                    <td>{{ ($surats->currentPage() - 1) * $surats->perPage() + $loop->iteration }}</td>
                                    <td><strong>{{ $surat->jenis_surat }}</strong></td>
                                    <td>
                                        @if ($surat->status === 'diajukan')
                                            <span class="badge bg-primary">Diajukan</span>
                                        @elseif ($surat->status === 'diproses')
                                            <span class="badge bg-warning">Diproses</span>
                                        @elseif ($surat->status === 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">{{ $surat->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $surat->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($surat->tanggal_selesai)
                                            {{ $surat->tanggal_selesai->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $surat->id }}" title="Lihat Detail">
                                            👁️
                                        </button>
                                        @if ($surat->status === 'selesai')
                                            @if ($surat->file_surat)
                                                <a href="{{ route('surat.view', $surat->id) }}" target="_blank" class="btn btn-sm btn-primary" title="Lihat Surat">
                                                    👓
                                                </a>
                                                <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-sm btn-success" title="Download Surat">
                                                    ⬇️
                                                </a>
                                            @else
                                                <button type="button" class="btn btn-sm btn-secondary fw-semibold" disabled aria-disabled="true" title="PDF sedang diproses" style="opacity:1;">
                                                    ⏳ Sedang diproses
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailModal{{ $surat->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title fw-bold">Detail Pengajuan Surat</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-2"><strong>Jenis Surat:</strong> {{ $surat->jenis_surat }}</p>
                                                <p class="mb-2"><strong>Status:</strong>
                                                    @if ($surat->status === 'diajukan')
                                                        <span class="badge bg-primary">Diajukan</span>
                                                    @elseif ($surat->status === 'diproses')
                                                        <span class="badge bg-warning">Diproses</span>
                                                    @elseif ($surat->status === 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @endif
                                                </p>
                                                <p class="mb-2"><strong>Tanggal Pengajuan:</strong> {{ $surat->created_at->format('d/m/Y H:i') }}</p>
                                                @if ($surat->tanggal_selesai)
                                                    <p class="mb-2"><strong>Tanggal Selesai:</strong> {{ $surat->tanggal_selesai->format('d/m/Y') }}</p>
                                                @endif
                                                @if ($surat->keterangan)
                                                    <p class="mb-2"><strong>Keterangan:</strong></p>
                                                    <div class="alert alert-light border">{{ $surat->keterangan }}</div>
                                                @endif
                                                @if ($surat->status === 'selesai')
                                                    <div class="alert alert-success">
                                                        ✓ Surat Anda sudah siap untuk diambil di kantor desa!
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $surats->links() }}
                </div>
            @else
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center py-5">
                        <p class="text-muted fs-5 mb-3">Anda belum mengajukan surat apapun.</p>
                        <a href="{{ route('surat') }}" class="btn btn-primary fw-semibold">
                            ➕ Ajukan Surat Pertama Anda
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
