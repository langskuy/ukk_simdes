@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header Section --}}
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-5 text-center">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <h1 class="display-4 fw-bold text-primary mb-3">{{ $desa['nama'] }}</h1>

                        @auth
                            @if(auth()->user()->role === 'admin')
                                <button class="btn btn-outline-secondary btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#editDesaModal" title="Edit Profil Desa">
                                    ✏️ Edit Profil
                                </button>
                            @endif
                        @endauth
                    </div>
                    <p class="fs-5 text-muted mb-0">
                        {{ $desa['kecamatan'] }}, {{ $desa['kabupaten'] }}, {{ $desa['provinsi'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Section --}}
    <div class="row mb-5">
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body p-4">
                    <i class="bi bi-people fs-2 text-primary mb-3"></i>
                    <h5 class="card-title fw-semibold">Populasi</h5>
                    <p class="card-text fs-4 text-success fw-bold">{{ $desa['populasi'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body p-4">
                    <i class="bi bi-map fs-2 text-info mb-3"></i>
                    <h5 class="card-title fw-semibold">Luas Wilayah</h5>
                    <p class="card-text fs-4 text-info fw-bold">{{ $desa['luas_wilayah'] ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body p-4">
                    <i class="bi bi-house-door fs-2 text-warning mb-3"></i>
                    <h5 class="card-title fw-semibold">Jumlah RT</h5>
                    <p class="card-text fs-4 text-warning fw-bold">{{ $desa['jumlah_rt'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body p-4">
                    <i class="bi bi-building fs-2 text-danger mb-3"></i>
                    <h5 class="card-title fw-semibold">Jumlah RW</h5>
                    <p class="card-text fs-4 text-danger fw-bold">{{ $desa['jumlah_rw'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Sejarah Section --}}
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold text-primary mb-3">Sejarah Desa</h3>
                    <p class="card-text text-dark lh-lg">
                        {{ $desa['sejarah'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Visi & Misi Section --}}
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold text-primary mb-3">Visi</h3>
                    <p class="card-text text-dark lh-lg">
                        {{ $desa['visi'] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold text-primary mb-3">Misi</h3>
                    <ul class="list-unstyled">
                        @foreach ($desa['misi'] as $item)
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <span class="text-dark">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Kontak Section --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold text-primary mb-4">Hubungi Kami</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted fw-semibold">Alamat</p>
                            <p class="text-dark fs-5">{{ $desa['kontak']['alamat'] }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <p class="mb-1 text-muted fw-semibold">Telepon</p>
                            <p class="text-dark fs-5">
                                <a href="tel:{{ str_replace(['(', ')', ' ', '-'], '', $desa['kontak']['telepon']) }}" class="text-decoration-none text-dark">
                                    {{ $desa['kontak']['telepon'] }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <p class="mb-1 text-muted fw-semibold">Email</p>
                            <p class="text-dark fs-5">
                                <a href="mailto:{{ $desa['kontak']['email'] }}" class="text-decoration-none text-dark">
                                    {{ $desa['kontak']['email'] }}
                                </a>
                            </p>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="mt-3">
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@auth
    @if(auth()->user()->role === 'admin')
        <?php
            $pop_num = intval(preg_replace('/[^0-9]/', '', $desa['populasi'] ?? '0'));
            // extract number (with decimal) from luas_wilayah
            $luas_num = 0;
            if (!empty($desa['luas_wilayah'])) {
                if (preg_match('/([0-9]+(?:\.[0-9]+)?)/', $desa['luas_wilayah'], $m)) {
                    $luas_num = $m[1];
                }
            }
            $rt_num = intval(preg_replace('/[^0-9]/', '', $desa['jumlah_rt'] ?? '0'));
            $rw_num = intval(preg_replace('/[^0-9]/', '', $desa['jumlah_rw'] ?? '0'));
            $misi_text = is_array($desa['misi'] ?? null) ? implode("\n", $desa['misi']) : ($desa['misi'] ?? '');
            $kontak_alamat = $desa['kontak']['alamat'] ?? '';
            $kontak_telepon = $desa['kontak']['telepon'] ?? '';
            $kontak_email = $desa['kontak']['email'] ?? '';
        ?>
        <!-- Edit Desa Modal -->
        <div class="modal fade" id="editDesaModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Profil Desa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('desa.update') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama Desa</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $desa['nama']) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kecamatan" class="form-label fw-semibold">Kecamatan</label>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan', $desa['kecamatan']) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kabupaten" class="form-label fw-semibold">Kabupaten</label>
                                    <input type="text" name="kabupaten" id="kabupaten" class="form-control" value="{{ old('kabupaten', $desa['kabupaten']) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="provinsi" class="form-label fw-semibold">Provinsi</label>
                                    <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', $desa['provinsi']) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="populasi" class="form-label fw-semibold">Populasi (jiwa)</label>
                                    <input type="number" name="populasi" id="populasi" class="form-control" min="0" value="{{ old('populasi', $pop_num) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="luas_wilayah" class="form-label fw-semibold">Luas Wilayah (km²)</label>
                                    <input type="number" step="0.01" name="luas_wilayah" id="luas_wilayah" class="form-control" value="{{ old('luas_wilayah', $luas_num) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_rt" class="form-label fw-semibold">Jumlah RT</label>
                                    <input type="number" name="jumlah_rt" id="jumlah_rt" class="form-control" min="0" value="{{ old('jumlah_rt', $rt_num) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_rw" class="form-label fw-semibold">Jumlah RW</label>
                                    <input type="number" name="jumlah_rw" id="jumlah_rw" class="form-control" min="0" value="{{ old('jumlah_rw', $rw_num) }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="sejarah" class="form-label fw-semibold">Sejarah</label>
                                    <textarea name="sejarah" id="sejarah" rows="4" class="form-control">{{ old('sejarah', $desa['sejarah']) }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="visi" class="form-label fw-semibold">Visi</label>
                                    <textarea name="visi" id="visi" rows="2" class="form-control">{{ old('visi', $desa['visi']) }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="misi" class="form-label fw-semibold">Misi (satu per baris)</label>
                                    <textarea name="misi" id="misi" rows="4" class="form-control">{{ old('misi', $misi_text) }}</textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-semibold">Kontak</label>
                                    <input type="text" name="kontak_alamat" class="form-control mb-2" placeholder="Alamat" value="{{ old('kontak_alamat', $kontak_alamat) }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" name="kontak_telepon" class="form-control" placeholder="Telepon" value="{{ old('kontak_telepon', $kontak_telepon) }}" inputmode="numeric">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="kontak_email" class="form-control" placeholder="Email" value="{{ old('kontak_email', $kontak_email) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endauth
