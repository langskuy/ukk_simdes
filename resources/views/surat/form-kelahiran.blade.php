@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-danger text-white fw-bold d-flex align-items-center justify-content-between">
                    <span>👶 Ajukan Surat Keterangan Kelahiran</span>
                    <a href="{{ route('surat') }}" class="btn btn-sm btn-light" title="Kembali">← Kembali</a>
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Kelahiran">

                        <!-- Info User -->
                        <div class="alert alert-info alert-dismissible">
                            <strong>Informasi Anda (Orang Tua):</strong><br>
                            Nama: <strong>{{ auth()->user()->name }}</strong><br>
                            Email: <strong>{{ auth()->user()->email }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <!-- Deskripsi Surat -->
                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-semibold mb-2">📄 Tentang Surat Ini:</h6>
                            <p class="mb-0 small">Surat Keterangan Kelahiran adalah dokumen resmi yang menyatakan kelahiran seorang anak di wilayah desa kami. Surat ini penting untuk administrasi kependudukan, akta kelahiran, dan keperluan pendidikan anak.</p>
                        </div>

                        <!-- Data Anak -->
                        <h6 class="fw-semibold mb-3 mt-3 border-top pt-3">👶 Data Anak yang Dilahirkan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_anak" class="form-label fw-semibold">Nama Anak <span class="text-danger">*</span></label>
                                <input type="text" name="nama_anak" id="nama_anak" class="form-control @error('nama_anak') is-invalid @enderror" 
                                       placeholder="Nama lengkap anak" required value="{{ old('nama_anak') }}">
                                @error('nama_anak') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin_anak" class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin_anak" id="jenis_kelamin_anak" class="form-select @error('jenis_kelamin_anak') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin_anak') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin_anak') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin_anak') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       required value="{{ old('tanggal_lahir') }}">
                                @error('tanggal_lahir') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       placeholder="Nama rumah sakit atau tempat lahir" required value="{{ old('tempat_lahir') }}">
                                @error('tempat_lahir') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="berat_lahir" class="form-label">Berat Lahir (gram) <span class="text-danger">*</span></label>
                            <input type="number" name="berat_lahir" id="berat_lahir" class="form-control @error('berat_lahir') is-invalid @enderror" 
                                   placeholder="Contoh: 3500" min="1000" max="6000" required value="{{ old('berat_lahir') }}">
                            @error('berat_lahir') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="panjang_lahir" class="form-label">Panjang Lahir (cm) <span class="text-danger">*</span></label>
                            <input type="number" name="panjang_lahir" id="panjang_lahir" class="form-control @error('panjang_lahir') is-invalid @enderror" 
                                   placeholder="Contoh: 50" min="30" max="60" step="0.1" required value="{{ old('panjang_lahir') }}">
                            @error('panjang_lahir') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Data Orang Tua -->
                        <h6 class="fw-semibold mb-3 mt-4 border-top pt-3">👨‍👩‍👧 Data Orang Tua</h6>
                        <div class="mb-3">
                            <label for="nama_ibu" class="form-label fw-semibold">Nama Ibu <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror" 
                                   placeholder="Nama lengkap ibu kandung" required value="{{ old('nama_ibu') }}">
                            @error('nama_ibu') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_ayah" class="form-label fw-semibold">Nama Ayah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ayah" id="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror" 
                                   placeholder="Nama lengkap ayah kandung" required value="{{ old('nama_ayah') }}">
                            @error('nama_ayah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik_ibu" class="form-label fw-semibold">NIK Ibu <span class="text-danger">*</span></label>
                                    <input type="text" name="nik_ibu" id="nik_ibu" class="form-control @error('nik_ibu') is-invalid @enderror" 
                                        placeholder="16 digit NIK ibu" required maxlength="16" value="{{ old('nik_ibu') }}" inputmode="numeric">
                                @error('nik_ibu') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nik_ayah" class="form-label fw-semibold">NIK Ayah <span class="text-danger">*</span></label>
                                    <input type="text" name="nik_ayah" id="nik_ayah" class="form-control @error('nik_ayah') is-invalid @enderror" 
                                        placeholder="16 digit NIK ayah" required maxlength="16" value="{{ old('nik_ayah') }}" inputmode="numeric">
                                @error('nik_ayah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                      rows="4" placeholder="Jelaskan informasi tambahan jika ada..." maxlength="1000">{{ old('keterangan') }}</textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                            @error('keterangan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Info Penting -->
                        <div class="alert alert-light border">
                            <h6 class="fw-semibold mb-2">💡 Catatan Penting:</h6>
                            <ul class="small mb-0">
                                <li>Pastikan semua data benar dan lengkap</li>
                                <li>Pengajuan akan diproses dalam 1-3 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika surat sudah siap</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                                <li>Bawa surat ini untuk membuat akta kelahiran di catatan sipil</li>
                                <li>Bawa identitas orang tua saat pengambilan surat</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger fw-semibold">✓ Ajukan Surat</button>
                            <a href="{{ route('surat') }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
