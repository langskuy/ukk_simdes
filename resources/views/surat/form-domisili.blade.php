@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-success text-white fw-bold d-flex align-items-center justify-content-between">
                    <span>🏠 Ajukan Surat Keterangan Domisili</span>
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Domisili">

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
                            <p class="mb-0 small">Surat Keterangan Domisili adalah bukti resmi bahwa Anda bertempat tinggal di wilayah desa kami. Surat ini diperlukan untuk berbagai keperluan administrasi seperti pendaftaran sekolah, pembukaan rekening bank, dan keperluan lainnya.</p>
                        </div>

                        <!-- Data Tempat Tinggal -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">Alamat Tempat Tinggal <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                      rows="3" placeholder="Contoh: Jl. Merdeka No. 123, RT 01/RW 02" required>{{ old('alamat') }}</textarea>
                            @error('alamat') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lama_tinggal" class="form-label fw-semibold">Lama Tinggal <span class="text-danger">*</span></label>
                                <input type="text" name="lama_tinggal" id="lama_tinggal" class="form-control @error('lama_tinggal') is-invalid @enderror" 
                                       placeholder="Contoh: 5 tahun" required value="{{ old('lama_tinggal') }}">
                                <small class="text-muted">Berapa lama Anda tinggal di alamat ini</small>
                                @error('lama_tinggal') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status_rumah" class="form-label fw-semibold">Status Rumah <span class="text-danger">*</span></label>
                                <select name="status_rumah" id="status_rumah" class="form-select @error('status_rumah') is-invalid @enderror" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Milik Sendiri" {{ old('status_rumah') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Menyewa/Kontrak" {{ old('status_rumah') == 'Menyewa/Kontrak' ? 'selected' : '' }}>Menyewa/Kontrak</option>
                                    <option value="Milik Orang Tua" {{ old('status_rumah') == 'Milik Orang Tua' ? 'selected' : '' }}>Milik Orang Tua</option>
                                    <option value="Milik Keluarga" {{ old('status_rumah') == 'Milik Keluarga' ? 'selected' : '' }}>Milik Keluarga</option>
                                </select>
                                @error('status_rumah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Informasi Tambahan (Conditional) -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#e8f4f8">
                                📍 Informasi Riwayat Tempat Tinggal
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat_sebelumnya" class="form-label">Alamat Sebelumnya (Opsional)</label>
                                        <textarea name="alamat_sebelumnya" id="alamat_sebelumnya" class="form-control" rows="2" placeholder="Alamat di mana Anda tinggal sebelumnya">{{ old('alamat_sebelumnya') }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alasan_pindah" class="form-label">Alasan Pindah Ke Sini (Opsional)</label>
                                        <input type="text" name="alasan_pindah" id="alasan_pindah" class="form-control" placeholder="Contoh: Pekerjaan, Keluarga, dll" value="{{ old('alasan_pindah') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pribadi Tambahan -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#d4edda">
                                👤 Data Pribadi Tambahan
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label">Nomor Identitas (NIK) <span class="text-danger">*</span></label>
                                        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror" 
                                               placeholder="16 digit NIK Anda" required maxlength="16" value="{{ old('nik') }}" inputmode="numeric">
                                        <small class="text-muted">Sesuai dengan KTP/identitas resmi</small>
                                        @error('nik') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="no_kk" class="form-label">Nomor Kartu Keluarga <span class="text-danger">*</span></label>
                                        <input type="text" name="no_kk" id="no_kk" class="form-control @error('no_kk') is-invalid @enderror" 
                                               placeholder="16 digit Nomor KK" required maxlength="16" value="{{ old('no_kk') }}" inputmode="numeric">
                                        @error('no_kk') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="no_hp" class="form-label">Nomor HP/Telepon <span class="text-danger">*</span></label>
                                        <input type="tel" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                                               placeholder="Contoh: 081234567890" required value="{{ old('no_hp') }}">
                                        @error('no_hp') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                               placeholder="Contoh: Bandung" required value="{{ old('tempat_lahir') }}">
                                        @error('tempat_lahir') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           required value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kependudukan -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#cfe2ff">
                                📍 Informasi Kependudukan Detail
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="rt_rw" class="form-label">RT/RW <span class="text-danger">*</span></label>
                                        <input type="text" name="rt_rw" id="rt_rw" class="form-control @error('rt_rw') is-invalid @enderror" 
                                               placeholder="Contoh: 001/002" required value="{{ old('rt_rw') }}">
                                        @error('rt_rw') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kelurahan" class="form-label">Kelurahan/Dusun <span class="text-danger">*</span></label>
                                        <input type="text" name="kelurahan" id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" 
                                               placeholder="Contoh: Dusun Merdeka" required value="{{ old('kelurahan') }}">
                                        @error('kelurahan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_rumah" class="form-label">Jenis Rumah <span class="text-danger">*</span></label>
                                        <select name="jenis_rumah" id="jenis_rumah" class="form-select @error('jenis_rumah') is-invalid @enderror" required>
                                            <option value="">-- Pilih Jenis --</option>
                                            <option value="Permanen" {{ old('jenis_rumah') == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                                            <option value="Semi Permanen" {{ old('jenis_rumah') == 'Semi Permanen' ? 'selected' : '' }}>Semi Permanen</option>
                                            <option value="Non Permanen" {{ old('jenis_rumah') == 'Non Permanen' ? 'selected' : '' }}>Non Permanen</option>
                                        </select>
                                        @error('jenis_rumah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="luas_rumah" class="form-label">Luas Rumah (meter) <span class="text-danger">*</span></label>
                                        <input type="text" name="luas_rumah" id="luas_rumah" class="form-control @error('luas_rumah') is-invalid @enderror" 
                                               placeholder="Contoh: 6x8 atau 48" required value="{{ old('luas_rumah') }}">
                                        @error('luas_rumah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tujuan Pengajuan -->
                        <div class="mb-3">
                            <label for="tujuan" class="form-label fw-semibold">Tujuan Pengajuan <span class="text-danger">*</span></label>
                            <select name="tujuan" id="tujuan" class="form-select @error('tujuan') is-invalid @enderror" required>
                                <option value="">-- Pilih Tujuan --</option>
                                <option value="Pendaftaran Sekolah" {{ old('tujuan') == 'Pendaftaran Sekolah' ? 'selected' : '' }}>Pendaftaran Sekolah</option>
                                <option value="Pembukaan Rekening Bank" {{ old('tujuan') == 'Pembukaan Rekening Bank' ? 'selected' : '' }}>Pembukaan Rekening Bank</option>
                                <option value="Izin Tempat Tinggal" {{ old('tujuan') == 'Izin Tempat Tinggal' ? 'selected' : '' }}>Izin Tempat Tinggal</option>
                                <option value="Kartu Pelajar" {{ old('tujuan') == 'Kartu Pelajar' ? 'selected' : '' }}>Kartu Pelajar</option>
                                <option value="Perizinan Bisnis" {{ old('tujuan') == 'Perizinan Bisnis' ? 'selected' : '' }}>Perizinan Bisnis</option>
                                <option value="Sertifikasi Tanah" {{ old('tujuan') == 'Sertifikasi Tanah' ? 'selected' : '' }}>Sertifikasi Tanah</option>
                                <option value="Keperluan Lainnya" {{ old('tujuan') == 'Keperluan Lainnya' ? 'selected' : '' }}>Keperluan Lainnya</option>
                            </select>
                            @error('tujuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
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
                                <li>Pastikan Anda terdaftar sebagai penduduk resmi desa</li>
                                <li>Pengajuan akan diproses dalam 1-3 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika surat sudah siap</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                                <li>Bawa identitas asli ketika mengambil surat</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success fw-semibold">✓ Ajukan Surat</button>
                            <a href="{{ route('surat') }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
