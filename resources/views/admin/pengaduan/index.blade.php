@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">📋 Kelola Pengaduan</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-danger text-white fw-bold">Daftar Pengaduan</div>
            <div class="card-body">
                @if ($pengaduans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pelapor</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengaduans as $pengaduan)
                                    <tr>
                                        <td>{{ ($pengaduans->currentPage() - 1) * $pengaduans->perPage() + $loop->iteration }}</td>
                                        <td><strong>{{ $pengaduan->judul }}</strong></td>
                                        <td>{{ $pengaduan->nama_pelapor ?? ($pengaduan->user?->name ?? '—') }}</td>
                                        <td>
                                            @if ($pengaduan->status === 'baru')
                                                <span class="badge bg-primary">Baru</span>
                                            @elseif ($pengaduan->status === 'proses')
                                                <span class="badge bg-warning">Diproses</span>
                                            @else
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $pengaduan->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-sm btn-info"
                                                title="Lihat Detail">👁️</a>
                                            <!-- Edit removed -->
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $pengaduan->id }}" title="Hapus">🗑️</button>
                                        </td>
                                    </tr>

                                    <!-- Modal Delete Pengaduan -->
                                    <div class="modal fade" id="deleteModal{{ $pengaduan->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title fw-bold text-white">Hapus Pengaduan</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-danger fw-semibold">⚠️ Anda yakin ingin menghapus pengaduan ini?
                                                    </p>
                                                    <p>Pengaduan <strong>{{ $pengaduan->judul }}</strong> dari
                                                        <strong>{{ $pengaduan->nama_pelapor }}</strong> akan dihapus secara permanen
                                                        dan tidak bisa dikembalikan.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.pengaduan.destroy', $pengaduan) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger fw-semibold">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $pengaduans->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted fs-5">Belum ada pengaduan masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
