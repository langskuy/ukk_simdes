@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center justify-content-between">
                    <span>📋 Ajukan Surat Keterangan Usaha</span>
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Usaha">

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
                            <p class="mb-0 small">Surat Keterangan Usaha digunakan untuk keperluan administrasi bisnis, pendaftaran usaha, atau perizinan. Surat ini menyatakan bahwa Anda adalah pemilik/pengelola usaha di wilayah desa kami.</p>
                        </div>

                        <!-- Detail Usaha -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_usaha" class="form-label fw-semibold">Nama Usaha <span class="text-danger">*</span></label>
                                <input type="text" name="nama_usaha" id="nama_usaha" class="form-control @error('nama_usaha') is-invalid @enderror" 
                                       placeholder="Contoh: Warung Makan Sehada" required value="{{ old('nama_usaha') }}">
                                @error('nama_usaha') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis_usaha" class="form-label fw-semibold">Jenis Usaha <span class="text-danger">*</span></label>
                                <select name="jenis_usaha" id="jenis_usaha" class="form-select @error('jenis_usaha') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Usaha --</option>
                                    <option value="Perdagangan" {{ old('jenis_usaha') == 'Perdagangan' ? 'selected' : '' }}>Perdagangan</option>
                                    <option value="Jasa" {{ old('jenis_usaha') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                    <option value="Pertanian" {{ old('jenis_usaha') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                    <option value="Peternakan" {{ old('jenis_usaha') == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                                    <option value="Perikanan" {{ old('jenis_usaha') == 'Perikanan' ? 'selected' : '' }}>Perikanan</option>
                                    <option value="Industri Rumahan" {{ old('jenis_usaha') == 'Industri Rumahan' ? 'selected' : '' }}>Industri Rumahan</option>
                                    <option value="Lainnya" {{ old('jenis_usaha') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_usaha') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_usaha" class="form-label fw-semibold">Alamat Usaha <span class="text-danger">*</span></label>
                            <textarea name="alamat_usaha" id="alamat_usaha" class="form-control @error('alamat_usaha') is-invalid @enderror" 
                                      rows="3" placeholder="Jl. Contoh No. 123" required>{{ old('alamat_usaha') }}</textarea>
                            @error('alamat_usaha') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Data Pengusaha -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#e8f4f8">
                                👤 Data Pengusaha
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
                            </div>
                        </div>

                        <!-- Detail Bisnis Lanjutan -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#fff3cd">
                                💼 Detail Bisnis Lanjutan
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tahun_berdiri" class="form-label">Tahun Berdiri <span class="text-danger">*</span></label>
                                        <input type="number" name="tahun_berdiri" id="tahun_berdiri" class="form-control @error('tahun_berdiri') is-invalid @enderror" 
                                               placeholder="Contoh: 2020" min="1900" max="2100" required value="{{ old('tahun_berdiri') }}">
                                        @error('tahun_berdiri') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="modal_usaha" class="form-label">Perkiraan Modal Usaha (Opsional)</label>
                                        <input type="text" name="modal_usaha" id="modal_usaha" class="form-control" placeholder="Contoh: 10 juta rupiah" value="{{ old('modal_usaha') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah_karyawan" class="form-label">Jumlah Karyawan <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_karyawan" id="jumlah_karyawan" class="form-control @error('jumlah_karyawan') is-invalid @enderror" 
                                           placeholder="Berapa orang yang bekerja" min="0" required value="{{ old('jumlah_karyawan') }}">
                                    @error('jumlah_karyawan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="skala_produksi" class="form-label">Skala Produksi (Opsional)</label>
                                    <select name="skala_produksi" id="skala_produksi" class="form-select">
                                        <option value="">-- Pilih --</option>
                                        <option value="Skala Kecil" {{ old('skala_produksi') == 'Skala Kecil' ? 'selected' : '' }}>Skala Kecil</option>
                                        <option value="Skala Menengah" {{ old('skala_produksi') == 'Skala Menengah' ? 'selected' : '' }}>Skala Menengah</option>
                                        <option value="Skala Besar" {{ old('skala_produksi') == 'Skala Besar' ? 'selected' : '' }}>Skala Besar</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tujuan Pengajuan -->
                        <div class="mb-3">
                            <label for="tujuan" class="form-label fw-semibold">Tujuan Pengajuan <span class="text-danger">*</span></label>
                            <select name="tujuan" id="tujuan" class="form-select @error('tujuan') is-invalid @enderror" required>
                                <option value="">-- Pilih Tujuan --</option>
                                <option value="Perizinan Usaha" {{ old('tujuan') == 'Perizinan Usaha' ? 'selected' : '' }}>Perizinan Usaha</option>
                                <option value="Kredit/Pinjaman Bank" {{ old('tujuan') == 'Kredit/Pinjaman Bank' ? 'selected' : '' }}>Kredit/Pinjaman Bank</option>
                                <option value="Izin Tempat Usaha" {{ old('tujuan') == 'Izin Tempat Usaha' ? 'selected' : '' }}>Izin Tempat Usaha</option>
                                <option value="Registrasi Usaha" {{ old('tujuan') == 'Registrasi Usaha' ? 'selected' : '' }}>Registrasi Usaha</option>
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
                                <li>Pastikan data usaha Anda sudah terdaftar di desa</li>
                                <li>Pengajuan akan diproses dalam 1-3 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika surat sudah siap</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                                <li>Bawa identitas asli ketika mengambil surat</li>
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
