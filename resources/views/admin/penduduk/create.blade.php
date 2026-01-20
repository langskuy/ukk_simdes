@extends('layouts.admin')

@section('title', 'Tambah Warga')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-person-plus-fill me-2 text-primary"></i>Tambah Data Warga</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <form action="{{ route('admin.penduduk.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">NIK</label>
                            <input type="text" name="nik" class="form-control rounded-3" value="{{ old('nik') }}" required
                                maxlength="16" minlength="16">
                            @error('nik') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control rounded-3" value="{{ old('nama') }}"
                                required>
                            @error('nama') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select rounded-3" required>
                                <option value="">Pilih...</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Alamat</label>
                            <textarea name="alamat" class="form-control rounded-3" rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.penduduk.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection