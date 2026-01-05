@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-bold">
                    ✏️ Edit Permintaan Surat
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.surat.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label fw-semibold">Jenis Surat</label>
                            <input type="text" id="jenis_surat" class="form-control" value="{{ $surat->jenis_surat }}" disabled>
                            <small class="text-muted">Jenis surat tidak bisa diubah</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_pemohon" class="form-label fw-semibold">Nama Pemohon</label>
                                <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" value="{{ $surat->nama_pemohon }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nik" class="form-label fw-semibold">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" value="{{ $surat->nik }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                            <input type="tel" id="no_hp" name="no_hp" class="form-control" value="{{ $surat->no_hp }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="4">{{ $surat->keterangan }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option value="diajukan" {{ $surat->status === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="diproses" {{ $surat->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $surat->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="{{ $surat->tanggal_selesai?->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold">💾 Simpan Perubahan</button>
                            <a href="{{ route('admin.surat.show', $surat) }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
