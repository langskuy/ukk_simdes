@extends('layouts.admin')

@section('title', 'Catat Transaksi')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Catat Transaksi Baru</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <form action="{{ route('admin.keuangan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Jenis Transaksi</label>
                            <select name="jenis" class="form-select rounded-3" required>
                                <option value="">Pilih Jenis...</option>
                                <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan
                                </option>
                                <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran
                                </option>
                            </select>
                            @error('jenis') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control rounded-3"
                                value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Kategori</label>
                            <input type="text" name="kategori" class="form-control rounded-3"
                                placeholder="Contoh: Dana Desa, Pembangunan Jalan" value="{{ old('kategori') }}" required>
                            <div class="form-text">Kelompokkan transaksi agar mudah dipantau.</div>
                            @error('kategori') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nominal (Rp)</label>
                            <input type="number" name="nominal" class="form-control rounded-3" placeholder="0"
                                value="{{ old('nominal') }}" required min="0">
                            @error('nominal') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control rounded-3" rows="3"
                                placeholder="Detail tambahan...">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Transaksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection