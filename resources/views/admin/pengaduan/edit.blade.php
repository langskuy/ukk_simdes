@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-bold">
                    ✏️ Edit Pengaduan
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold">Judul Pengaduan</label>
                            <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                                value="{{ old('judul', $pengaduan->judul) }}" required>
                            @error('judul') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="isi" class="form-label fw-semibold">Isi Pengaduan</label>
                            <textarea id="isi" name="isi" class="form-control @error('isi') is-invalid @enderror" 
                                rows="5" required>{{ old('isi', $pengaduan->isi) }}</textarea>
                            @error('isi') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_pelapor" class="form-label fw-semibold">Nama Pelapor</label>
                            <input type="text" id="nama_pelapor" name="nama_pelapor" class="form-control @error('nama_pelapor') is-invalid @enderror" 
                                value="{{ old('nama_pelapor', $pengaduan->nama_pelapor) }}" required>
                            @error('nama_pelapor') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email', $pengaduan->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_hp" class="form-label fw-semibold">No. HP</label>
                                <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                    value="{{ old('no_hp', $pengaduan->no_hp) }}" required>
                                @error('no_hp') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="baru" {{ old('status', $pengaduan->status) === 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="proses" {{ old('status', $pengaduan->status) === 'proses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ old('status', $pengaduan->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold">💾 Simpan Perubahan</button>
                            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
