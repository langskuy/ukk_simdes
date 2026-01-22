@extends('layouts.admin')

@section('title', 'Master Data Warga')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Data Penduduk</h5>
            <a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary rounded-3">
                <i class="bi bi-plus-lg me-2"></i>Tambah Warga
            </a>
        </div>
        <div class="card-body p-4 pt-0">
            <form action="{{ route('admin.penduduk.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control border-end-0 bg-light" placeholder="Cari NIK atau Nama..."
                        name="search" value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 bg-light text-muted" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">NIK</th>
                            <th class="border-0">Nama Lengkap</th>
                            <th class="border-0">L/P</th>
                            <th class="border-0">Alamat</th>
                            <th class="border-0 rounded-end text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penduduks as $penduduk)
                            <tr>
                                <td class="fw-bold text-muted">{{ $penduduk->nik }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $penduduk->nama }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $penduduk->jenis_kelamin == 'L' ? 'bg-info text-dark' : 'bg-danger' }} bg-opacity-10 rounded-pill px-3">
                                        {{ $penduduk->jenis_kelamin }}
                                    </span>
                                </td>
                                <td class="small">{{ Str::limit($penduduk->alamat, 50) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.penduduk.edit', $penduduk) }}"
                                        class="btn btn-sm btn-light text-primary me-1"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('admin.penduduk.destroy', $penduduk) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                    <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                    Belum ada data warga.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $penduduks->links() }}
            </div>
        </div>
    </div>
@endsection