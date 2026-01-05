@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-warning text-dark fw-bold">
                    ✏️ Edit Kegiatan
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Error!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold">Judul Kegiatan</label>
                            <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" 
                                   value="{{ old('judul', $kegiatan->judul) }}" required>
                            @error('judul') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                      rows="5">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                            @error('deskripsi') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label fw-semibold">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', $kegiatan->tanggal?->format('Y-m-d')) }}">
                            @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label fw-semibold">Foto Kegiatan</label>
                            @if ($kegiatan->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $kegiatan->foto) }}" alt="Foto" style="max-width: 200px; border-radius: 8px;">
                                </div>
                            @endif
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" 
                                   accept="image/*">
                            @error('foto') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning fw-semibold">Simpan Perubahan</button>
                            <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
