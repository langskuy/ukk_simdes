@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-danger text-white fw-bold">
                    📋 Detail Pengaduan
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Judul</p>
                            <h5 class="fw-bold">{{ $pengaduan->judul }}</h5>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            @if ($pengaduan->status === 'baru')
                                <span class="badge bg-primary fs-6">Baru</span>
                            @elseif ($pengaduan->status === 'proses')
                                <span class="badge bg-warning fs-6">Diproses</span>
                            @else
                                <span class="badge bg-success fs-6">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Pelapor</p>
                            <p>{{ $pengaduan->nama_pelapor ?? ($pengaduan->user?->name ?? '—') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">NIK</p>
                            <p>{{ $pengaduan->nik ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Nomor HP</p>
                            <p>{{ $pengaduan->no_hp ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Tanggal Pengaduan</p>
                            <p>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted mb-1">Isi Pengaduan</p>
                        <div class="alert alert-light border">
                            <p>{{ $pengaduan->isi }}</p>
                        </div>
                    </div>

                    @if ($pengaduan->lampiran)
                        <div class="mb-3">
                            <p class="text-muted mb-1">Lampiran</p>
                            @php
                                $lampiranPath = $pengaduan->lampiran;
                                $isImage = preg_match('/\.(jpg|jpeg|png|gif|bmp)$/i', $lampiranPath);
                            @endphp
                            
                            @if ($isImage)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $lampiranPath) }}" alt="Lampiran" class="img-fluid rounded" style="max-width: 300px;">
                                </div>
                            @endif
                            
                            <a href="{{ asset('storage/' . $lampiranPath) }}" class="btn btn-sm btn-secondary" download>📥 Download</a>
                            @if ($isImage)
                                <a href="{{ asset('storage/' . $lampiranPath) }}" class="btn btn-sm btn-info" target="_blank">👁️ Lihat</a>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="button" class="btn btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#updateStatusModal">⚙️ Update Status</button>
                        </form>
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">← Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold">Update Status Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <label for="status" class="form-label fw-semibold">Pilih Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="baru" {{ $pengaduan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="proses" {{ $pengaduan->status === 'proses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
