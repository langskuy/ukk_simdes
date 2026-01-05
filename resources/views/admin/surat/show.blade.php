@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-secondary text-white fw-bold">
                    📄 Detail Permintaan Surat
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Jenis Surat</p>
                            <h5 class="fw-bold">{{ $surat->jenis_surat }}</h5>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            @if ($surat->status === 'diajukan')
                                <span class="badge bg-primary fs-6">Diajukan</span>
                            @elseif ($surat->status === 'diproses')
                                <span class="badge bg-warning fs-6">Diproses</span>
                            @else
                                <span class="badge bg-success fs-6">Selesai</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Nama Pemohon</p>
                            <p>{{ $surat->nama_pemohon ?? ($surat->user?->name ?? '—') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">NIK</p>
                            <p>{{ $surat->nik ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Nomor HP</p>
                            <p>{{ $surat->no_hp ?? '—' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Tanggal Pengajuan</p>
                            <p>{{ $surat->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    @if ($surat->keterangan)
                        <div class="mb-3">
                            <p class="text-muted mb-1">Keterangan</p>
                            <div class="alert alert-light border">
                                <p>{{ $surat->keterangan }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($surat->tanggal_selesai)
                        <div class="mb-3">
                            <p class="text-muted mb-1">Tanggal Selesai</p>
                            <p>{{ $surat->tanggal_selesai->format('d/m/Y') }}</p>
                        </div>
                    @endif

                    @if ($surat->file_surat)
                        <div class="mb-3">
                            <p class="text-muted mb-1">File Surat</p>
                            <p class="mb-2">✓ File sudah diunggah</p>
                            @if (isset($fileIsPdf) && $fileIsPdf)
                                <a href="{{ route('surat.view', $surat->id) }}" target="_blank" class="btn btn-sm btn-info">
                                    👁️ Lihat File
                                </a>
                            @else
                                <div class="alert alert-danger py-2">
                                    File yang diunggah tidak valid atau bukan PDF. Mohon unggah ulang file PDF yang benar.
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#updateStatusModal">⚙️ Update Status</button>
                        <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#uploadFileModal">📤 Upload File Surat</button>
                        <button type="button" class="btn btn-success fw-semibold" data-bs-toggle="modal" data-bs-target="#generatePdfModal">🔄 Generate PDF Otomatis</button>
                        <a href="{{ route('admin.surat.index') }}" class="btn btn-secondary">← Kembali</a>
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
                <h5 class="modal-title fw-bold">Update Status Surat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.surat.update', $surat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <label for="status" class="form-label fw-semibold">Pilih Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="diajukan" {{ $surat->status === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="diproses" {{ $surat->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $surat->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <label for="tanggal_selesai" class="form-label fw-semibold mt-3">Tanggal Selesai (opsional)</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ $surat->tanggal_selesai?->format('Y-m-d') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Upload File -->
<div class="modal fade" id="uploadFileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Upload File Surat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.surat.update', $surat) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <label for="file_surat" class="form-label fw-semibold">Pilih File PDF</label>
                    <input type="file" name="file_surat" id="file_surat" class="form-control" accept=".pdf" required>
                    <small class="text-muted d-block mt-2">Format: PDF, Ukuran maksimal 5MB</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Generate PDF Otomatis -->
<div class="modal fade" id="generatePdfModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Generate PDF Otomatis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.surat.update', $surat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Klik tombol di bawah untuk generate PDF otomatis dari data surat ini.</p>
                    <p class="alert alert-info mb-0"><small>PDF akan dibuat dari template surat dengan data pemohon dan keterangan. File otomatis tersimpan dan bisa langsung didownload oleh warga.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="generate_pdf" value="1" class="btn btn-success fw-semibold">Generate PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
