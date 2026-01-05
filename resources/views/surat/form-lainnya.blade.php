@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-secondary text-white fw-bold d-flex align-items-center justify-content-between">
                    <span>📑 Ajukan Surat Keterangan Lainnya</span>
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
                        <input type="hidden" name="jenis_surat" value="Surat Keterangan Lainnya">

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
                            <p class="mb-0 small">Kategori ini digunakan untuk jenis surat keterangan desa yang tidak termasuk dalam kategori umum. Silakan jelaskan jenis surat yang Anda butuhkan secara detail.</p>
                        </div>

                        <!-- Jenis Surat Spesifik -->
                        <div class="mb-3">
                            <label for="jenis_surat_khusus" class="form-label fw-semibold">Jenis Surat yang Diminta <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_surat_khusus" id="jenis_surat_khusus" class="form-control @error('jenis_surat_khusus') is-invalid @enderror" 
                                   placeholder="Contoh: Surat Izin Memancing, Surat Keterangan Wanprestasi, dll" required value="{{ old('jenis_surat_khusus') }}">
                            <small class="text-muted">Jelaskan dengan jelas jenis surat yang Anda butuhkan</small>
                            @error('jenis_surat_khusus') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tujuan Pengajuan -->
                        <div class="mb-3">
                            <label for="tujuan" class="form-label fw-semibold">Tujuan Pengajuan <span class="text-danger">*</span></label>
                            <input type="text" name="tujuan" id="tujuan" class="form-control @error('tujuan') is-invalid @enderror" 
                                   placeholder="Contoh: Keperluan Administrasi, Perizinan, dll" required value="{{ old('tujuan') }}">
                            @error('tujuan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Informasi Penerima/Tujuan Surat -->
                        <div class="card bg-light mb-3">
                            <div class="card-header fw-semibold" style="background-color:#e0e7ff">
                                👤 Informasi Penerima/Lembaga Tujuan
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_lembaga" class="form-label">Nama Lembaga/Instansi Penerima <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_lembaga" id="nama_lembaga" class="form-control @error('nama_lembaga') is-invalid @enderror" 
                                               placeholder="Contoh: PT. ABC, BRI, Dinas Pendidikan, dll" required value="{{ old('nama_lembaga') }}">
                                        @error('nama_lembaga') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat_lembaga" class="form-label">Alamat Lembaga/Instansi (Opsional)</label>
                                        <input type="text" name="alamat_lembaga" id="alamat_lembaga" class="form-control" 
                                               placeholder="Jalan, Kota, Provinsi" value="{{ old('alamat_lembaga') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="kontak_lembaga" class="form-label">Kontak/Email Lembaga (Opsional)</label>
                                    <input type="text" name="kontak_lembaga" id="kontak_lembaga" class="form-control" 
                                           placeholder="Nomor telepon atau email" value="{{ old('kontak_lembaga') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Detail dan Keterangan -->
                        <div class="mb-3">
                            <label for="detail_permintaan" class="form-label fw-semibold">Detail Permintaan <span class="text-danger">*</span></label>
                            <textarea name="detail_permintaan" id="detail_permintaan" class="form-control @error('detail_permintaan') is-invalid @enderror" 
                                      rows="4" placeholder="Jelaskan secara detail apa yang Anda butuhkan dari surat ini..." required maxlength="2000">{{ old('detail_permintaan') }}</textarea>
                            <small class="text-muted">Maksimal 2000 karakter. Semakin detail akan membantu proses persetujuan.</small>
                            @error('detail_permintaan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan Tambahan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                      rows="3" placeholder="Informasi tambahan yang mungkin diperlukan..." maxlength="1000">{{ old('keterangan') }}</textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                            @error('keterangan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Info Penting -->
                        <div class="alert alert-light border">
                            <h6 class="fw-semibold mb-2">💡 Catatan Penting:</h6>
                            <ul class="small mb-0">
                                <li>Jelaskan permintaan Anda sedetail mungkin agar dapat diproses dengan cepat</li>
                                <li>Jenis surat khusus mungkin memerlukan verifikasi lebih lanjut</li>
                                <li>Pengajuan akan diproses dalam 2-5 hari kerja</li>
                                <li>Anda akan menerima notifikasi penerimaan atau penolakan</li>
                                <li>Hubungi kantor desa jika ada pertanyaan lebih lanjut</li>
                                <li>Surat dapat diambil di kantor desa pada jam kerja</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-secondary fw-semibold">✓ Ajukan Surat</button>
                            <a href="{{ route('surat') }}" class="btn btn-outline-secondary">← Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
