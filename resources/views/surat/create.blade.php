@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-bold">
                    📝 Ajukan Surat Desa
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

                    <form action="{{ route('surat.store') }}" method="POST">
                        @csrf

                        <!-- Info User -->
                        <div class="alert alert-info alert-dismissible">
                            <strong>Informasi Anda:</strong><br>
                            Nama: <strong>{{ auth()->user()->name }}</strong><br>
                            Email: <strong>{{ auth()->user()->email }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <!-- Jenis Surat -->
                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label fw-semibold">Jenis Surat <span class="text-danger">*</span></label>
                            <select name="jenis_surat" id="jenis_surat" class="form-select @error('jenis_surat') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="Surat Keterangan Usaha" {{ request('jenis') == 'usaha' || old('jenis_surat') == 'Surat Keterangan Usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                <option value="Surat Keterangan Domisili" {{ request('jenis') == 'domisili' || old('jenis_surat') == 'Surat Keterangan Domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                <option value="Surat Keterangan Tidak Mampu" {{ request('jenis') == 'tidak_mampu' || old('jenis_surat') == 'Surat Keterangan Tidak Mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                <option value="Surat Keterangan Pindah" {{ request('jenis') == 'pindah' || old('jenis_surat') == 'Surat Keterangan Pindah' ? 'selected' : '' }}>Surat Keterangan Pindah</option>
                                <option value="Surat Keterangan Kelahiran" {{ request('jenis') == 'kelahiran' || old('jenis_surat') == 'Surat Keterangan Kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                <option value="Surat Keterangan Lainnya" {{ request('jenis') == 'lainnya' || old('jenis_surat') == 'Surat Keterangan Lainnya' ? 'selected' : '' }}>Surat Keterangan Lainnya</option>
                            </select>
                            @error('jenis_surat') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan/Alasan Pengajuan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                      rows="5" placeholder="Jelaskan alasan dan kebutuhan Anda..." maxlength="1000">{{ old('keterangan') }}</textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                            @error('keterangan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-light border">
                            <h6 class="fw-semibold mb-2">💡 Catatan Penting:</h6>
                            <ul class="small mb-0">
                                <li>Pengajuan surat akan diproses dalam 1-3 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika surat sudah siap</li>
                                <li>Pastikan data Anda sudah terisi lengkap di profil</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold">✓ Ajukan Surat</button>
                            <a href="{{ route('surat') }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
