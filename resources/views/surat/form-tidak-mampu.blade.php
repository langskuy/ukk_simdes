@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-warning text-white fw-bold d-flex align-items-center justify-content-between">
                    <span>💰 Ajukan Surat Keterangan Tidak Mampu</span>
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Tidak Mampu">

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
                            <p class="mb-0 small">Surat Keterangan Tidak Mampu adalah dokumen resmi yang menyatakan bahwa keluarga Anda termasuk dalam kategori tidak mampu secara ekonomi. Surat ini digunakan untuk berbagai keperluan sosial seperti beasiswa, bantuan kesehatan, dan program-program pemerintah lainnya.</p>
                        </div>

                        <!-- Data Pribadi Tambahan -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#f5e6ff">
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
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_anggota_keluarga" class="form-label fw-semibold">Jumlah Anggota Keluarga <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_anggota_keluarga" id="jumlah_anggota_keluarga" class="form-control @error('jumlah_anggota_keluarga') is-invalid @enderror" 
                                   placeholder="Contoh: 4" required min="1" value="{{ old('jumlah_anggota_keluarga') }}">
                            @error('jumlah_anggota_keluarga') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pekerjaan" class="form-label fw-semibold">Pekerjaan Utama <span class="text-danger">*</span></label>
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                       placeholder="Contoh: Buruh/Petani/Dagang Kecil" required value="{{ old('pekerjaan') }}">
                                @error('pekerjaan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="penghasilan_bulanan" class="form-label fw-semibold">Penghasilan Bulanan Rata-rata <span class="text-danger">*</span></label>
                                <input type="text" name="penghasilan_bulanan" id="penghasilan_bulanan" class="form-control @error('penghasilan_bulanan') is-invalid @enderror" 
                                       placeholder="Contoh: Rp 1.500.000" required value="{{ old('penghasilan_bulanan') }}">
                                @error('penghasilan_bulanan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Alasan Pengajuan -->
                        <div class="mb-3">
                            <label for="alasan_pengajuan" class="form-label fw-semibold">Alasan Pengajuan <span class="text-danger">*</span></label>
                            <select name="alasan_pengajuan" id="alasan_pengajuan" class="form-select @error('alasan_pengajuan') is-invalid @enderror" required>
                                <option value="">-- Pilih Alasan --</option>
                                <option value="Beasiswa Pendidikan" {{ old('alasan_pengajuan') == 'Beasiswa Pendidikan' ? 'selected' : '' }}>Beasiswa Pendidikan</option>
                                <option value="Bantuan Kesehatan" {{ old('alasan_pengajuan') == 'Bantuan Kesehatan' ? 'selected' : '' }}>Bantuan Kesehatan</option>
                                <option value="Program Bantuan Sosial" {{ old('alasan_pengajuan') == 'Program Bantuan Sosial' ? 'selected' : '' }}>Program Bantuan Sosial</option>
                                <option value="Kartu Indonesia Pintar" {{ old('alasan_pengajuan') == 'Kartu Indonesia Pintar' ? 'selected' : '' }}>Kartu Indonesia Pintar</option>
                                <option value="Bantuan Keluarga Kurang Mampu" {{ old('alasan_pengajuan') == 'Bantuan Keluarga Kurang Mampu' ? 'selected' : '' }}>Bantuan Keluarga Kurang Mampu</option>
                                <option value="Lainnya" {{ old('alasan_pengajuan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('alasan_pengajuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Informasi Aset Keluarga -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#ffe5e5">
                                🏠 Informasi Aset Keluarga
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status_rumah" class="form-label">Status Rumah <span class="text-danger">*</span></label>
                                        <select name="status_rumah" id="status_rumah" class="form-select @error('status_rumah') is-invalid @enderror" required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Milik Sendiri" {{ old('status_rumah') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                            <option value="Sewa" {{ old('status_rumah') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                            <option value="Menumpang" {{ old('status_rumah') == 'Menumpang' ? 'selected' : '' }}>Menumpang</option>
                                            <option value="Gadai" {{ old('status_rumah') == 'Gadai' ? 'selected' : '' }}>Gadai</option>
                                        </select>
                                        @error('status_rumah') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="luas_rumah" class="form-label">Luas Rumah / Tanah (Opsional)</label>
                                        <input type="text" name="luas_rumah" id="luas_rumah" class="form-control" placeholder="Contoh: 6 x 8 meter" value="{{ old('luas_rumah') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="aset_lainnya" class="form-label">Aset/Kekayaan Lainnya yang Dimiliki (Opsional)</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aset[]" value="Kendaraan Bermotor" id="aset_kendaraan">
                                        <label class="form-check-label" for="aset_kendaraan">Kendaraan Bermotor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aset[]" value="Sawah/Kebun" id="aset_sawah" {{ in_array('Sawah/Kebun', old('aset', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aset_sawah">Sawah/Kebun</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aset[]" value="Ternak" id="aset_ternak" {{ in_array('Ternak', old('aset', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aset_ternak">Ternak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aset[]" value="Emas/Perhiasan" id="aset_emas" {{ in_array('Emas/Perhiasan', old('aset', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aset_emas">Emas/Perhiasan</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi Khusus -->
                        <div class="mb-3">
                            <label for="kondisi_khusus" class="form-label fw-semibold">Kondisi Khusus (Jika Ada)</label>
                            <textarea name="kondisi_khusus" id="kondisi_khusus" class="form-control @error('kondisi_khusus') is-invalid @enderror" 
                                      rows="3" placeholder="Contoh: Memiliki anak penyandang cacat, orang tua sakit-sakitan, dll...">{{ old('kondisi_khusus') }}</textarea>
                            @error('kondisi_khusus') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
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
                                <li>Data yang Anda berikan akan diverifikasi oleh perangkat desa</li>
                                <li>Pengajuan akan diproses dalam 3-7 hari kerja</li>
                                <li>Anda akan menerima notifikasi ketika proses verifikasi selesai</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                                <li>Bawa identitas asli dan dokumen pendukung saat pengambilan</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning fw-semibold">✓ Ajukan Surat</button>
                            <a href="{{ route('surat') }}" class="btn btn-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
