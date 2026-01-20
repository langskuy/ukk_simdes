@extends('layouts.app')

@section('content')
    <style>
        /* Custom Stepper Styles */
        .step-indicator {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
            border: 2px solid #dee2e6;
        }

        .step-indicator.active {
            background-color: #0d6efd;
            color: white !important;
            /* Ensure text is white */
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
        }

        .step-indicator.completed {
            background-color: #198754;
            color: white !important;
            /* Ensure text is white */
            border-color: #198754;
        }

        .step-label {
            margin-top: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .step-label.active {
            color: #0d6efd;
        }

        .progress-track {
            position: absolute;
            top: 20px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #e9ecef;
            z-index: 1;
        }

        .progress-fill {
            height: 100%;
            background-color: #198754;
            transition: width 0.4s ease;
        }

        /* Card & Form Enhancements */
        .wizard-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .wizard-header {
            background: linear-gradient(135deg, #0b5ed7 0%, #055160 100%);
            padding: 2rem;
            color: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .file-upload-wrapper {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.2s;
            cursor: pointer;
        }

        .file-upload-wrapper:hover {
            border-color: #0d6efd;
            background: #eff6ff;
        }

        /* Animation */
        .step-content {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                {{-- Breadcrumbs Navigation --}}
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('warga.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ajukan Surat</li>
                    </ol>
                </nav>

                <div class="card wizard-card">

                    <div class="wizard-header text-center">
                        <h3 class="fw-bold mb-1">📝 Layanan Surat Desa</h3>
                        <p class="mb-0 text-white-50">Ajukan surat keterangan dengan mudah dan cepat</p>
                    </div>

                    <div class="card-body p-4 p-md-5">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Perhatian!</strong>
                                <ul class="mb-0 mt-1 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Visual Stepper -->
                        <div class="position-relative mb-5 mx-2 mx-md-5">
                            <div class="progress-track">
                                <div class="progress-fill" id="progressFill" style="width: 0%;"></div>
                            </div>
                            <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                                <div class="text-center step-wrapper" style="width: 80px;">
                                    <div class="step-indicator active mx-auto" id="step1-indicator">1</div>
                                    <div class="step-label active mx-auto" id="step1-label">Pilih Surat</div>
                                </div>
                                <div class="text-center step-wrapper" style="width: 80px;">
                                    <div class="step-indicator mx-auto" id="step2-indicator">2</div>
                                    <div class="step-label mx-auto" id="step2-label">Berkas</div>
                                </div>
                                <div class="text-center step-wrapper" style="width: 80px;">
                                    <div class="step-indicator mx-auto" id="step3-indicator">3</div>
                                    <div class="step-label mx-auto" id="step3-label">Data</div>
                                </div>
                                <div class="text-center step-wrapper" style="width: 80px;">
                                    <div class="step-indicator mx-auto" id="step4-indicator">4</div>
                                    <div class="step-label mx-auto" id="step4-label">Konfirmasi</div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data"
                            id="wizardForm">
                            @csrf

                            <!-- STEP 1: Pilih Jenis Surat -->
                            <div id="step1" class="step-content">
                                <div class="text-center mb-4">
                                    <h4 class="fw-bold text-dark">Apa yang Anda butuhkan?</h4>
                                    <p class="text-muted">Pilih jenis surat yang sesuai dengan keperluan Anda</p>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <select name="jenis_surat" id="jenis_surat"
                                                class="form-select form-select-lg shadow-sm border-2" required
                                                style="padding: 1rem;">
                                                <option value="">-- Pilih Jenis Surat --</option>
                                                <option value="Surat Keterangan Usaha" {{ (old('jenis_surat') == 'Surat Keterangan Usaha' || request('jenis_surat') == 'Surat Keterangan Usaha') ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                                <option value="Surat Keterangan Domisili" {{ (old('jenis_surat') == 'Surat Keterangan Domisili' || request('jenis_surat') == 'Surat Keterangan Domisili') ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                                <option value="Surat Keterangan Tidak Mampu" {{ (old('jenis_surat') == 'Surat Keterangan Tidak Mampu' || request('jenis_surat') == 'Surat Keterangan Tidak Mampu') ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                                <option value="Surat Keterangan Pindah" {{ (old('jenis_surat') == 'Surat Keterangan Pindah' || request('jenis_surat') == 'Surat Keterangan Pindah') ? 'selected' : '' }}>Surat Keterangan Pindah</option>
                                                <option value="Surat Keterangan Kelahiran" {{ (old('jenis_surat') == 'Surat Keterangan Kelahiran' || request('jenis_surat') == 'Surat Keterangan Kelahiran') ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                                <option value="Surat Pengantar SKCK" {{ (old('jenis_surat') == 'Surat Pengantar SKCK' || request('jenis_surat') == 'Surat Pengantar SKCK') ? 'selected' : '' }}>Surat Pengantar SKCK</option>
                                                <option value="Surat Keterangan Lainnya" {{ (old('jenis_surat') == 'Surat Keterangan Lainnya' || request('jenis_surat') == 'Surat Keterangan Lainnya') ? 'selected' : '' }}>Surat Keterangan Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="d-grid">
                                            <button type="button"
                                                class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold py-3"
                                                onclick="nextStep(2)">
                                                Lanjut Langkah Berikutnya <i
                                                    class="bi bi-arrow-right-short fs-4 align-middle ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 2: Upload Berkas -->
                            <div id="step2" class="step-content d-none">
                                <div class="text-center mb-4">
                                    <h4 class="fw-bold text-dark">Lengkapi Persyaratan</h4>
                                    <p class="text-muted">Unggah dokumen pendukung asli (PDF/JPG/PNG, Maks 2MB)</p>
                                </div>

                                <div class="row g-4">
                                    <!-- Common Fields -->
                                    <div class="col-md-6">
                                        <div class="file-upload-wrapper h-100">
                                            <div class="mb-3">
                                                <i class="bi bi-person-badge display-4 text-primary opacity-50"></i>
                                            </div>
                                            <label class="form-label fw-bold display-block">Kartu Tanda Penduduk (KTP) <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="files[ktp]" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted d-block mt-2">Format: PDF/JPG/PNG</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="file-upload-wrapper h-100">
                                            <div class="mb-3">
                                                <i class="bi bi-people-fill display-4 text-primary opacity-50"></i>
                                            </div>
                                            <label class="form-label fw-bold">Kartu Keluarga (KK) <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="files[kk]" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted d-block mt-2">Format: PDF/JPG/PNG</small>
                                        </div>
                                    </div>

                                    <!-- Dynamic Uploads -->
                                    <div class="col-md-6 dynamic-upload d-none"
                                        data-for="Surat Keterangan Domisili Surat Keterangan Pindah">
                                        <div class="file-upload-wrapper h-100">
                                            <div class="mb-3"><i
                                                    class="bi bi-file-earmark-text display-4 text-info opacity-50"></i>
                                            </div>
                                            <label class="form-label fw-bold">Pengantar RT/RW <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="files[pengantar_rt]" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                        </div>
                                    </div>

                                    <div class="col-md-6 dynamic-upload d-none" data-for="Surat Keterangan Kelahiran">
                                        <div class="file-upload-wrapper h-100">
                                            <div class="mb-3"><i class="bi bi-hospital display-4 text-info opacity-50"></i>
                                            </div>
                                            <label class="form-label fw-bold">Surat Keterangan Lahir (RS/Bidan) <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="files[ket_lahir]" class="form-control"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                        </div>
                                    </div>

                                    <div class="col-md-6 dynamic-upload d-none" data-for="Surat Keterangan Usaha">
                                        <div class="file-upload-wrapper h-100">
                                            <div class="mb-3"><i class="bi bi-shop display-4 text-info opacity-50"></i>
                                            </div>
                                            <label class="form-label fw-bold">Foto Tempat Usaha (Opsional)</label>
                                            <input type="file" name="files[foto_usaha]" class="form-control"
                                                accept=".jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-5">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold"
                                        onclick="prevStep(1)">
                                        <i class="bi bi-arrow-left me-2"></i> Kembali
                                    </button>
                                    <button type="button" class="btn btn-primary rounded-pill px-5 fw-bold"
                                        onclick="nextStep(3)">
                                        Lanjut <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 3: Data Tambahan -->
                            <div id="step3" class="step-content d-none">
                                <div class="text-center mb-4">
                                    <h4 class="fw-bold text-dark">Data Detail</h4>
                                    <p class="text-muted">Lengkapi formulir berikut secara akurat</p>
                                    <div class="alert alert-info border-0 rounded-3 small text-start">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <strong>Dokumen Persyaratan:</strong> Pastikan Anda telah menyiapkan fotokopi <strong>KTP & KK</strong> serta <strong>Surat Pengantar RT/RW</strong> untuk diserahkan ke kantor desa saat pengambilan surat.
                                    </div>
                                </div>

                                <!-- DATA PRIBADI FOR ALL -->
                                <div class="card bg-light border-0 mb-4 rounded-3">
                                    <div class="card-body p-4">
                                        <h6 class="fw-bold text-primary mb-3"><i
                                                class="bi bi-person-lines-fill me-2"></i>Info Pemohon</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control bg-white"
                                                        value="{{ Auth::user()->name }}" readonly id="nameFloating">
                                                    <label for="nameFloating">Nama Lengkap</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="nik" class="form-control bg-white"
                                                        placeholder="NIK" required
                                                        maxlength="16" minlength="16" pattern="\d{16}" title="NIK harus 16 digit angka"
                                                        value="{{ Auth::user()->nik ?? old('nik') }}" id="nikFloating">
                                                    <label for="nikFloating">Nomor NIK</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="no_kk" class="form-control bg-white"
                                                        placeholder="No. KK" required
                                                        value="{{ Auth::user()->no_kk ?? old('no_kk') }}" id="kkFloating">
                                                    <label for="kkFloating">Nomor Kartu Keluarga (KK)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="jenis_kelamin" class="form-select bg-white"
                                                        id="jkFloating" required>
                                                        <option value="">Pilih...</option>
                                                        <option value="Laki-laki" {{ (Auth::user()->jenis_kelamin ?? old('jenis_kelamin')) == 'Laki-laki' ? 'selected' : '' }}>
                                                            Laki-laki</option>
                                                        <option value="Perempuan" {{ (Auth::user()->jenis_kelamin ?? old('jenis_kelamin')) == 'Perempuan' ? 'selected' : '' }}>
                                                            Perempuan</option>
                                                    </select>
                                                    <label for="jkFloating">Jenis Kelamin</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="tempat_lahir" class="form-control bg-white"
                                                        placeholder="Tempat Lahir" required
                                                        value="{{ Auth::user()->tempat_lahir ?? old('tempat_lahir') }}"
                                                        id="tmptFloating">
                                                    <label for="tmptFloating">Tempat Lahir</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="date" name="tanggal_lahir" class="form-control bg-white"
                                                        placeholder="Tanggal Lahir" required
                                                        value="{{ Auth::user()->tanggal_lahir ?? old('tanggal_lahir') }}"
                                                        id="tglFloating">
                                                    <label for="tglFloating">Tanggal Lahir</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="kewarganegaraan" class="form-select bg-white"
                                                        id="wnFloating" required>
                                                        <option value="WNI" {{ (old('kewarganegaraan') ?? 'WNI') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                                        <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                                                    </select>
                                                    <label for="wnFloating">Kewarganegaraan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="agama" class="form-select bg-white" id="agamaFloating"
                                                        required>
                                                        <option value="">Pilih...</option>
                                                        <option value="Islam" {{ (Auth::user()->agama ?? old('agama')) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                        <option value="Kristen" {{ (Auth::user()->agama ?? old('agama')) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                        <option value="Katolik" {{ (Auth::user()->agama ?? old('agama')) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                        <option value="Hindu" {{ (Auth::user()->agama ?? old('agama')) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                        <option value="Buddha" {{ (Auth::user()->agama ?? old('agama')) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                        <option value="Konghucu" {{ (Auth::user()->agama ?? old('agama')) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                                    </select>
                                                    <label for="agamaFloating">Agama</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="pekerjaan" class="form-control bg-white"
                                                        placeholder="Pekerjaan" required
                                                        value="{{ Auth::user()->pekerjaan ?? old('pekerjaan') }}"
                                                        id="kerjaFloating">
                                                    <label for="kerjaFloating">Pekerjaan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <select name="status_perkawinan" class="form-select bg-white"
                                                        id="statusFloating" required>
                                                        <option value="">Pilih...</option>
                                                        <option value="Belum Kawin" {{ (Auth::user()->status_perkawinan ?? old('status_perkawinan')) == 'Belum Kawin' ? 'selected' : '' }}>
                                                            Belum Kawin</option>
                                                        <option value="Kawin" {{ (Auth::user()->status_perkawinan ?? old('status_perkawinan')) == 'Kawin' ? 'selected' : '' }}>Kawin
                                                        </option>
                                                        <option value="Cerai Hidup" {{ (Auth::user()->status_perkawinan ?? old('status_perkawinan')) == 'Cerai Hidup' ? 'selected' : '' }}>
                                                            Cerai Hidup</option>
                                                        <option value="Cerai Mati" {{ (Auth::user()->status_perkawinan ?? old('status_perkawinan')) == 'Cerai Mati' ? 'selected' : '' }}>
                                                            Cerai Mati</option>
                                                    </select>
                                                    <label for="statusFloating">Status Perkawinan</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="no_hp" class="form-control bg-white"
                                                        placeholder="08..." required
                                                        value="{{ Auth::user()->no_hp ?? old('no_hp') }}" id="hpFloating">
                                                    <label for="hpFloating">Nomor WhatsApp Aktif</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                 <div class="form-floating">
                                                     <textarea name="alamat_asal" class="form-control bg-white"
                                                         placeholder="Alamat Asal" id="alamatFloating"
                                                         style="height: 100px"
                                                         required>{{ Auth::user()->alamat ?? old('alamat_asal') }}</textarea>
                                                     <label for="alamatFloating">Alamat Asal (Sesuai KTP)</label>
                                                 </div>
                                             </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="number" name="rt" class="form-control bg-white"
                                                        placeholder="RT" required
                                                        value="{{ Auth::user()->rt ?? old('rt') }}" id="rtFloating">
                                                    <label for="rtFloating">RT</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="number" name="rw" class="form-control bg-white"
                                                        placeholder="RW" required
                                                        value="{{ Auth::user()->rw ?? old('rw') }}" id="rwFloating">
                                                    <label for="rwFloating">RW</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DYNAMIC FIELDS CONTAINER -->
                                <div id="dynamic-fields-container">

                                    <!-- USAHA -->
                                    <div class="dynamic-group d-none" data-group="Surat Keterangan Usaha">
                                        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Detail Usaha</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nama Usaha</label>
                                                <input type="text" name="nama_usaha" class="form-control" placeholder="Misal: Toko Berkah" value="{{ old('nama_usaha') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Jenis Usaha</label>
                                                <input type="text" name="jenis_usaha" class="form-control" placeholder="Misal: Perdagangan Sembako" value="{{ old('jenis_usaha') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Alamat Tempat Usaha</label>
                                                <textarea name="alamat_usaha" class="form-control" rows="2" placeholder="Alamat lengkap lokasi usaha">{{ old('alamat_usaha') }}</textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold small">Lama Usaha (Tahun/Bulan)</label>
                                                <input type="text" name="lama_usaha" class="form-control" placeholder="Misal: 2 Tahun" value="{{ old('lama_usaha') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold small">Modal Usaha (Opsional)</label>
                                                <input type="text" name="modal_usaha" class="form-control" placeholder="Rp. 5.000.000" value="{{ old('modal_usaha') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold small">Penghasilan per Bulan (Opsional)</label>
                                                <input type="text" name="penghasilan_bulanan" class="form-control" placeholder="Rp. 2.000.000" value="{{ old('penghasilan_bulanan') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DOMISILI -->
                                    <div class="dynamic-group d-none" data-group="Surat Keterangan Domisili">
                                        <h5 class="fw-bold mb-3">Informasi Domisili</h5>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Alamat Domisili Sekarang</label>
                                                <textarea name="alamat_domisili" class="form-control" rows="2" placeholder="Jl. ... / Perumahan ...">{{ old('alamat_domisili') }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Lama Tinggal</label>
                                                <input type="text" name="lama_tinggal" class="form-control" placeholder="Misal: 2 Tahun" value="{{ old('lama_tinggal') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Keperluan Surat</label>
                                                <input type="text" name="keperluan" class="form-control" placeholder="Misal: Syarat Melamar Pekerjaan" value="{{ old('keperluan') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TIDAK MAMPU -->
                                    <div class="dynamic-group d-none" data-group="Surat Keterangan Tidak Mampu">
                                        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Informasi Ekonomi & Keluarga</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Penghasilan per Bulan</label>
                                                <input type="text" name="penghasilan_bulanan" class="form-control" placeholder="Rp. 1.000.000" value="{{ old('penghasilan_bulanan') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Keperluan Surat</label>
                                                <input type="text" name="keperluan" class="form-control" placeholder="Misal: Beasiswa / Bantuan Sosial" value="{{ old('keperluan') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Daftar Anggota Keluarga (Dalam 1 KK)</label>
                                                <textarea name="data_keluarga" class="form-control" rows="3" placeholder="1. Nama (Hubungan)&#10;2. Nama (Hubungan)">{{ old('data_keluarga') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PINDAH -->
                                    <div class="dynamic-group d-none" data-group="Surat Keterangan Pindah">
                                        <h5 class="fw-bold mb-3">Informasi Kepindahan</h5>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Alamat Tujuan Lengkap</label>
                                                <textarea name="alamat_tujuan" class="form-control" rows="2" placeholder="Jl. ... Desa ... Kec. ... Kab. ...">{{ old('alamat_tujuan') }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Alasan Pindah</label>
                                                <input type="text" name="alasan_pindah" class="form-control" placeholder="Misal: Bekerja / Ikut Orang Tua" value="{{ old('alasan_pindah') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Jumlah Anggota Keluarga yang Ikut</label>
                                                <input type="number" name="jumlah_pengikut" class="form-control" min="0" value="{{ old('jumlah_pengikut', 0) }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Daftar Nama Anggota Keluarga (Jika ada)</label>
                                                <textarea name="daftar_pengikut" class="form-control" rows="3" placeholder="1. Nama (NIK)&#10;2. Nama (NIK)">{{ old('daftar_pengikut') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- KELAHIRAN -->
                                    <div class="dynamic-group d-none" data-group="Surat Keterangan Kelahiran">
                                        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">I. Data Bayi</h5>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nama Bayi</label>
                                                <input type="text" name="nama_anak" class="form-control" placeholder="Nama Lengkap Bayi" value="{{ old('nama_anak') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                                <select name="jenis_kelamin_anak" class="form-select">
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir_anak" class="form-control" placeholder="Kota/Kab" value="{{ old('tempat_lahir_anak') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir_anak" class="form-control" value="{{ old('tanggal_lahir_anak') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Waktu Lahir</label>
                                                <input type="time" name="waktu_lahir" class="form-control" value="{{ old('waktu_lahir') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Anak Ke-berapa</label>
                                                <input type="number" name="anak_ke" class="form-control" min="1" placeholder="1 / 2 / 3..." value="{{ old('anak_ke') }}">
                                            </div>
                                        </div>

                                        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">II. Data Orang Tua</h5>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-6 border-end">
                                                <p class="fw-bold text-muted small mb-2">Ayah</p>
                                                <div class="mb-2">
                                                    <label class="form-label small">Nama Ayah</label>
                                                    <input type="text" name="nama_ayah" class="form-control form-control-sm" value="{{ old('nama_ayah') }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small">NIK Ayah</label>
                                                    <input type="text" name="nik_ayah" class="form-control form-control-sm" 
                                                        maxlength="16" minlength="16" pattern="\d{16}" title="NIK harus 16 digit angka"
                                                        value="{{ old('nik_ayah', Auth::user()->nik) }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small">TTL Ayah</label>
                                                    <input type="text" name="ttl_ayah" class="form-control form-control-sm" placeholder="Kota, Tgl-Bln-Thn" value="{{ old('ttl_ayah') }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small">Pekerjaan Ayah</label>
                                                    <input type="text" name="pekerjaan_ayah" class="form-control form-control-sm" value="{{ old('pekerjaan_ayah', Auth::user()->pekerjaan) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="fw-bold text-muted small mb-2">Ibu</p>
                                                <div class="mb-2">
                                                    <label class="form-label small">Nama Ibu</label>
                                                    <input type="text" name="nama_ibu" class="form-control form-control-sm" value="{{ old('nama_ibu') }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small">NIK Ibu</label>
                                                    <input type="text" name="nik_ibu" class="form-control form-control-sm" 
                                                        maxlength="16" minlength="16" pattern="\d{16}" title="NIK harus 16 digit angka"
                                                        value="{{ old('nik_ibu') }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small">TTL Ibu</label>
                                                    <input type="text" name="ttl_ibu" class="form-control form-control-sm" placeholder="Kota, Tgl-Bln-Thn" value="{{ old('ttl_ibu') }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label small">Pekerjaan Ibu</label>
                                                    <input type="text" name="pekerjaan_ibu" class="form-control form-control-sm" value="{{ old('pekerjaan_ibu') }}">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Alamat Orang Tua</label>
                                                <textarea name="alamat_ortu" class="form-control" rows="2">{{ old('alamat_ortu', Auth::user()->alamat) }}</textarea>
                                            </div>
                                        </div>

                                        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">III. Saksi (Opsional)</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small">Nama Saksi 1</label>
                                                <input type="text" name="saksi_1" class="form-control form-control-sm" value="{{ old('saksi_1') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold small">Nama Saksi 2</label>
                                                <input type="text" name="saksi_2" class="form-control form-control-sm" value="{{ old('saksi_2') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SKCK -->
                                    <div class="dynamic-group d-none" data-group="Surat Pengantar SKCK">
                                        <h5 class="fw-bold mb-3">Keperluan SKCK</h5>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Keperluan Pembuatan SKCK</label>
                                                <input type="text" name="keperluan" class="form-control" placeholder="Misal: Melamar Pekerjaan di PT. XXX" value="{{ old('keperluan') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- LAINNYA -->
                                    <div class="col-12 mt-4">
                                        <label class="form-label fw-bold">Keterangan Tambahan (Opsional)</label>
                                        <textarea name="keterangan" class="form-control" rows="3"
                                            placeholder="Informasi tambahan surat...">{{ old('keterangan') }}</textarea>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-between mt-5">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold"
                                        onclick="prevStep(2)">
                                        <i class="bi bi-arrow-left me-2"></i> Kembali
                                    </button>
                                    <button type="button" class="btn btn-primary rounded-pill px-5 fw-bold"
                                        onclick="nextStep(4)">
                                        Review <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 4: Review & Submit -->
                            <div id="step4" class="step-content d-none">
                                <div class="text-center mb-4">
                                    <h4 class="fw-bold text-dark">Konfirmasi</h4>
                                    <p class="text-muted">Pastikan data yang Anda isi sudah benar</p>
                                </div>

                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body p-4">
                                        <div class="row mb-3 pb-3 border-bottom">
                                            <div class="col-4 text-muted small">Jenis Surat</div>
                                            <div class="col-8 fw-bold text-primary" id="preview-jenis">Not Selected</div>
                                        </div>
                                        <div class="row mb-3 pb-3 border-bottom">
                                            <div class="col-4 text-muted small">NIK Pemohon</div>
                                            <div class="col-8 fw-bold" id="preview-nik">Not Set</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-4 text-muted small">Nama Pemohon</div>
                                            <div class="col-8 fw-bold">{{ Auth::user()->name }}</div>
                                        </div>

                                        <div class="alert alert-warning mt-3 mb-0 small">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Estimasi waktu pengerjaan surat: <strong>1-3 Hari Kerja</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check mb-4 p-3 border rounded shadow-sm bg-white">
                                    <input class="form-check-input ms-1 mt-1" type="checkbox" id="agreecheck" required
                                        style="transform: scale(1.2);">
                                    <label class="form-check-label small ms-3 lh-sm" for="agreecheck">
                                        Saya menyatakan bahwa data yang saya isi adalah benar, valid, dan dapat
                                        dipertanggungjawabkan secara hukum.
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold"
                                        onclick="prevStep(3)">
                                        <i class="bi bi-arrow-left me-2"></i> Kembali
                                    </button>
                                    <button type="submit"
                                        class="btn btn-success btn-lg rounded-pill px-5 fw-bold shadow-sm">
                                        <i class="bi bi-send-fill me-2"></i> Kirim Pengajuan
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('d-none'));
            // Show current step
            document.getElementById('step' + step).classList.remove('d-none');

            // Update Indicator
            updateIndicator(step);

            // Run logic for Step 2 (Dynamic Uploads)
            if (step === 2) {
                updateUploadFields();
            }
            // Run logic for Step 3 (Dynamic Inputs)
            if (step === 3) {
                updateInputFields();
            }
            // Run logic for Step 4 (Preview)
            if (step === 4) {
                updatePreview();
            }

            currentStep = step;
        }

        function nextStep(target) {
            // Basic Validation
            if (target > currentStep) {
                if (!validateStep(currentStep)) return;
            }
            showStep(target);
        }

        function prevStep(target) {
            showStep(target);
        }

        function updateIndicator(step) {
            // Update Progress Bar
            const width = ((step - 1) / 3) * 100; // 0%, 33%, 66%, 100%
            document.getElementById('progressFill').style.width = width + '%';

            // Update Indicators
            for (let i = 1; i <= 4; i++) {
                let el = document.getElementById('step' + i + '-indicator');
                let label = document.getElementById('step' + i + '-label');

                el.classList.remove('active', 'completed');
                label.classList.remove('active');

                if (i < step) {
                    el.classList.add('completed');
                    el.innerHTML = '<i class="bi bi-check-lg"></i>';
                    label.classList.add('active'); // Keep label styled for completed steps too? or just active?
                } else if (i === step) {
                    el.classList.add('active');
                    el.innerText = i;
                    label.classList.add('active');
                } else {
                    el.innerText = i;
                }
            }
        }

        function validateStep(step) {
            const stepEl = document.getElementById('step' + step);
            const inputs = stepEl.querySelectorAll('select[required], input[required], textarea[required]');
            let valid = true;

            inputs.forEach(input => {
                if (input.offsetParent === null) return; // Skip hidden inputs
                if (!input.value) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                // Toast or simpler alert
                // Using bootstrap toast logic would be great but let's stick to standard alert for simplicity in script
                alert('Mohon lengkapi semua field bertanda * sebelum lanjut.');
            }
            return valid;
        }

        function updateUploadFields() {
            const jenis = document.getElementById('jenis_surat').value;
            document.querySelectorAll('.dynamic-upload').forEach(el => {
                const forTypes = el.getAttribute('data-for');
                if (forTypes && forTypes.includes(jenis)) {
                    el.classList.remove('d-none');
                } else {
                    el.classList.add('d-none');
                }
            });
        }

        function updateInputFields() {
            const jenis = document.getElementById('jenis_surat').value;
            // Hide all dynamic groups and disable their inputs
            document.querySelectorAll('.dynamic-group').forEach(el => {
                el.classList.add('d-none');
                el.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = true;
                });
            });

            // Find matching group, show it and enable its inputs
            const target = document.querySelector(`.dynamic-group[data-group="${jenis}"]`);
            if (target) {
                target.classList.remove('d-none');
                target.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = false;
                });
            }
        }

        function updatePreview() {
            document.getElementById('preview-jenis').innerText = document.getElementById('jenis_surat').value;
            document.getElementById('preview-nik').innerText = document.querySelector('input[name="nik"]').value;
        }
    </script>
@endsection