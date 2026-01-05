
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-danger text-white fw-bold">
                    🛎️ Ajukan Pengaduan / Laporan Warga
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Error!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="alert alert-info">
                            <strong>Informasi Anda:</strong><br>
                            Nama: <strong>{{ auth()->user()->name }}</strong><br>
                            Email: <strong>{{ auth()->user()->email }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="nama_pelapor" class="form-label">Nama Pelapor <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pelapor" id="nama_pelapor" class="form-control @error('nama_pelapor') is-invalid @enderror" value="{{ old('nama_pelapor', auth()->user()->name) }}" required>
                            @error('nama_pelapor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" inputmode="numeric" maxlength="16">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required inputmode="numeric" maxlength="20">
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                            @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label">Uraian / Isi Pengaduan <span class="text-danger">*</span></label>
                            <textarea name="isi" id="isi" rows="6" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi') }}</textarea>
                            @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lampiran" class="form-label">Lampiran (opsional)</label>
                            <input type="file" name="lampiran" id="lampiran" class="form-control @error('lampiran') is-invalid @enderror">
                            <small class="text-muted">jpg, png, pdf, doc, docx — maksimal 5MB</small>
                            @error('lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger fw-semibold">✓ Ajukan Pengaduan</button>
                            <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
