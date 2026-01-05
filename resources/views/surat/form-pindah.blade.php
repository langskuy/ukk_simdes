@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-info text-white fw-bold d-flex align-items-center justify-content-between">
                    <span>📍 Ajukan Surat Keterangan Pindah</span>
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Pindah">

                        <!-- Info User -->
                        <div class="alert alert-info alert-dismissible">
                            <strong>Informasi Anda:</strong><br>
                            Nama: <strong>{{ auth()->user()->name }}</strong><br>
                            Email: <strong>{{ auth()->user()->email }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <!-- Deskripsi Surat -->
                        <div class="alert alert-light border mb-4">
                            <h6 class="fw-semibold mb-2">📄 Tentang Surat Ini:</h6>
                            <p class="mb-0 small">Surat Keterangan Pindah adalah dokumen resmi yang menyatakan Anda pindah dari wilayah desa kami ke desa/kota lain. Surat ini diperlukan untuk proses perubahan domisili dan registrasi penduduk di tempat tujuan.</p>
                        </div>

                        <!-- Data Pribadi -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#e8f5e9">
                                👤 Data Pribadi & Identitas
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label">Nomor Identitas (NIK) <span class="text-danger">*</span></label>
                                        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" 
                                               placeholder="16 digit NIK" required maxlength="16" value="{{ old('nik') }}" inputmode="numeric">
                                        @error('nik') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="no_hp" class="form-label">Nomor HP/Telepon <span class="text-danger">*</span></label>
                                        <input type="tel" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                               placeholder="Contoh: 081234567890" required value="{{ old('no_hp') }}">
                                        @error('no_hp') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="no_kk" class="form-label">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                    <input type="text" name="no_kk" id="no_kk" class="form-control @error('no_kk') is-invalid @enderror" 
                                           placeholder="16 digit Nomor KK" required maxlength="16" value="{{ old('no_kk') }}" inputmode="numeric">
                                    @error('no_kk') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-3 mt-3 border-top pt-3">📋 Data Alamat Saat Ini</h6>
                        <div class="mb-3">
                            <label for="alamat_lama" class="form-label fw-semibold">Alamat Saat Ini (di desa kami) <span class="text-danger">*</span></label>
                            <textarea name="alamat_lama" id="alamat_lama" class="form-control @error('alamat_lama') is-invalid @enderror" 
                                      rows="2" placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02" required>{{ old('alamat_lama') }}</textarea>
                            @error('alamat_lama') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Data Alamat Tujuan -->
                        <h6 class="fw-semibold mb-3 mt-4 border-top pt-3">📍 Data Alamat Tujuan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="desa_tujuan" class="form-label fw-semibold">Desa/Kelurahan Tujuan <span class="text-danger">*</span></label>
                                <input type="text" name="desa_tujuan" id="desa_tujuan" class="form-control @error('desa_tujuan') is-invalid @enderror" 
                                       placeholder="Contoh: Desa Maju" required value="{{ old('desa_tujuan') }}">
                                @error('desa_tujuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kecamatan_tujuan" class="form-label fw-semibold">Kecamatan Tujuan <span class="text-danger">*</span></label>
                                <input type="text" name="kecamatan_tujuan" id="kecamatan_tujuan" class="form-control @error('kecamatan_tujuan') is-invalid @enderror" 
                                       placeholder="Contoh: Kecamatan Jaya" required value="{{ old('kecamatan_tujuan') }}">
                                @error('kecamatan_tujuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kabupaten_tujuan" class="form-label fw-semibold">Kabupaten/Kota Tujuan <span class="text-danger">*</span></label>
                                <input type="text" name="kabupaten_tujuan" id="kabupaten_tujuan" class="form-control @error('kabupaten_tujuan') is-invalid @enderror" 
                                       placeholder="Contoh: Kabupaten Jaya" required value="{{ old('kabupaten_tujuan') }}">
                                @error('kabupaten_tujuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="provinsi_tujuan" class="form-label fw-semibold">Provinsi Tujuan <span class="text-danger">*</span></label>
                                <input type="text" name="provinsi_tujuan" id="provinsi_tujuan" class="form-control @error('provinsi_tujuan') is-invalid @enderror" 
                                       placeholder="Contoh: Jawa Barat" required value="{{ old('provinsi_tujuan') }}">
                                @error('provinsi_tujuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_baru" class="form-label fw-semibold">Alamat Lengkap di Tempat Tujuan <span class="text-danger">*</span></label>
                            <textarea name="alamat_baru" id="alamat_baru" class="form-control @error('alamat_baru') is-invalid @enderror" 
                                      rows="2" placeholder="Contoh: Jl. Sudirman No. 456, RT 02/RW 03" required>{{ old('alamat_baru') }}</textarea>
                            @error('alamat_baru') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alasan Pindah -->
                        <div class="mb-3">
                            <label for="alasan_pindah" class="form-label fw-semibold">Alasan Pindah <span class="text-danger">*</span></label>
                            <select name="alasan_pindah" id="alasan_pindah" class="form-select @error('alasan_pindah') is-invalid @enderror" required>
                                <option value="">-- Pilih Alasan --</option>
                                <option value="Pekerjaan" {{ old('alasan_pindah') == 'Pekerjaan' ? 'selected' : '' }}>Pekerjaan</option>
                                <option value="Pendidikan" {{ old('alasan_pindah') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Keluarga" {{ old('alasan_pindah') == 'Keluarga' ? 'selected' : '' }}>Keluarga</option>
                                <option value="Kesehatan" {{ old('alasan_pindah') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="Usaha/Bisnis" {{ old('alasan_pindah') == 'Usaha/Bisnis' ? 'selected' : '' }}>Usaha/Bisnis</option>
                                <option value="Lainnya" {{ old('alasan_pindah') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('alasan_pindah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Detail Rencana Pindah -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#e8f5e9">
                                📅 Detail Rencana Pindah
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_pindah" class="form-label">Tanggal Rencana Pindah <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal_pindah" id="tanggal_pindah" class="form-control @error('tanggal_pindah') is-invalid @enderror" required value="{{ old('tanggal_pindah') }}">
                                        @error('tanggal_pindah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lama_tinggal_lama" class="form-label">Lama Tinggal di Alamat Lama <span class="text-danger">*</span></label>
                                        <input type="text" name="lama_tinggal_lama" id="lama_tinggal_lama" class="form-control @error('lama_tinggal_lama') is-invalid @enderror" 
                                               placeholder="Contoh: 10 tahun" required value="{{ old('lama_tinggal_lama') }}">
                                        @error('lama_tinggal_lama') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="anggota_keluarga" class="form-label">Jumlah Anggota Keluarga yang Ikut Pindah (Opsional)</label>
                                    <input type="number" name="anggota_keluarga" id="anggota_keluarga" class="form-control" min="0" placeholder="Berapa orang termasuk Anda" value="{{ old('anggota_keluarga') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                      rows="4" placeholder="Jelaskan informasi atau alasan tambahan jika ada..." maxlength="1000">{{ old('keterangan') }}</textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                            @error('keterangan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Info Penting -->
                        <div class="alert alert-light border">
                            <h6 class="fw-semibold mb-2">💡 Catatan Penting:</h6>
                            <ul class="small mb-0">
                                <li>Pastikan data alamat tujuan sudah akurat dan lengkap</li>
                                <li>Pengajuan akan diproses dalam 1-3 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika surat sudah siap</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                                <li>Bawa surat ini ke desa tujuan untuk perubahan domisili</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-info fw-semibold">✓ Ajukan Surat</button>
                            <a href="{{ route('surat') }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
