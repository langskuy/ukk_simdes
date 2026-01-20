@extends('layouts.admin')

@section('title', 'Manajemen Keuangan')

@section('content')
    {{-- Ringkasan Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-4 shadow-sm bg-success text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="bi bi-arrow-down-left fs-4"></i>
                        </div>
                        <h6 class="mb-0 text-white-50 text-uppercase small fw-bold">Pemasukan</h6>
                    </div>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-4 shadow-sm bg-danger text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="bi bi-arrow-up-right fs-4"></i>
                        </div>
                        <h6 class="mb-0 text-white-50 text-uppercase small fw-bold">Pengeluaran</h6>
                    </div>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-4 shadow-sm bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>
                        <h6 class="mb-0 text-white-50 text-uppercase small fw-bold">Saldo Akhir</h6>
                    </div>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="card border-0 rounded-4 shadow-sm">
        <div
            class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-cash-stack me-2 text-primary"></i>Riwayat Transaksi</h5>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.keuangan.index') }}" class="btn btn-light border" title="Reset Filter"><i
                        class="bi bi-arrow-counterclockwise"></i></a>
                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Filter Jenis
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('admin.keuangan.index', ['jenis' => 'pemasukan']) }}">Pemasukan</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('admin.keuangan.index', ['jenis' => 'pengeluaran']) }}">Pengeluaran</a></li>
                    </ul>
                </div>
                <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary rounded-3">
                    <i class="bi bi-plus-lg me-2"></i>Catat Transaksi
                </a>
            </div>
        </div>
        <div class="card-body p-4 pt-0">
            <form action="{{ route('admin.keuangan.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control border-end-0 bg-light"
                        placeholder="Cari keterangan atau kategori..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 bg-light text-muted" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">Tanggal</th>
                            <th class="border-0">Kategori</th>
                            <th class="border-0">Keterangan</th>
                            <th class="border-0">Nominal</th>
                            <th class="border-0 rounded-end text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksi as $item)
                            <tr>
                                <td class="text-muted small">{{ $item->tanggal->format('d M Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $item->jenis == 'pemasukan' ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $item->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }} px-3 py-2 rounded-pill">
                                        {{ $item->kategori }}
                                    </span>
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td class="fw-bold {{ $item->jenis == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                    {{ $item->jenis == 'pemasukan' ? '+' : '-' }} Rp
                                    {{ number_format($item->nominal, 0, ',', '.') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.keuangan.edit', $item) }}"
                                        class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('admin.keuangan.destroy', $item) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus data transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger"><i
                                                class="bi bi-trash-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-wallet2 fs-1 d-block mb-3 opacity-25"></i>
                                    Belum ada data transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>
@endsection