@extends('layouts.app')

@push('styles')
    <style>
        /* ===== FIX GLITCH PADA TOMBOL AKSI ===== */
        .action-btn {
            width: 36px;
            height: 36px;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border-radius: 8px !important;
            transition: none !important;
        }

        .action-btn:hover,
        .action-btn:focus,
        .action-btn:active {
            transform: none !important;
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">📄 Kelola Surat Desa</h3>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Dashboard</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-secondary text-white fw-bold">Daftar Permintaan Surat</div>
            <div class="card-body">
                @if ($surats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Surat</th>
                                    <th>Pemohon</th>
                                    <th>Status</th>
                                    <th>Tanggal Ajukan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surats as $surat)
                                    <tr>
                                        <td>{{ ($surats->currentPage() - 1) * $surats->perPage() + $loop->iteration }}</td>
                                        <td><strong>{{ $surat->jenis_surat }}</strong></td>
                                        <td>{{ $surat->nama_pemohon ?? ($surat->user?->name ?? '—') }}</td>
                                        <td>
                                            @if ($surat->status === 'diajukan')
                                                <span class="badge bg-primary">Diajukan</span>
                                            @elseif ($surat->status === 'diproses')
                                                <span class="badge bg-warning">Diproses</span>
                                            @else
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $surat->created_at->format('d/m/Y') }}</td>

                                        <td class="text-center">

                                            <!-- Lihat detail -->
                                            <a href="{{ route('admin.surat.show', $surat) }}" class="action-btn"
                                                style="background:#00AEEF; color:white;" title="Lihat Detail">👁️</a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.surat.edit', $surat) }}" class="action-btn"
                                                style="background:#0D6EFD; color:white;" title="Edit">✏️</a>

                                            {{-- Update Status button removed as requested (status update flow unchanged) --}}

                                            <!-- Hapus (open global modal) -->
                                            <button type="button" class="action-btn"
                                                style="background:#DC3545; color:white;"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-destroy-url="{{ route('admin.surat.destroy', $surat) }}"
                                                data-surat-id="{{ $surat->id }}"
                                                data-surat-name="{{ $surat->nama_pemohon }}"
                                                data-surat-jenis="{{ $surat->jenis_surat }}"
                                                title="Hapus">🗑️</button>

                                        </td>

                                    </tr>

                                    {{-- per-item modals removed; using global modals below to improve performance/responsiveness --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $surats->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted fs-5">Belum ada permintaan surat masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // GLOBAL Update Status Modal handling
            var updateModal = document.getElementById('updateStatusModal');
            if (updateModal) {
                updateModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var updateUrl = button.getAttribute('data-update-url');
                    var status = button.getAttribute('data-status') || 'diajukan';
                    var tanggal = button.getAttribute('data-tanggal') || '';

                    var form = updateModal.querySelector('form');
                    if (form && updateUrl) {
                        form.action = updateUrl;
                        // set status select
                        var sel = form.querySelector('select[name="status"]');
                        if (sel) sel.value = status;
                        var dt = form.querySelector('input[name="tanggal_selesai"]');
                        if (dt) dt.value = tanggal;

                        // protect submit button from double-click
                        var submitBtn = form.querySelector('button[type=submit]');
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = submitBtn.getAttribute('data-original') || submitBtn.textContent;
                            submitBtn.dataset.clicked = '0';

                            var handler = function (e) {
                                if (submitBtn.dataset.clicked === '1') {
                                    e.preventDefault();
                                    return;
                                }
                                submitBtn.dataset.clicked = '1';
                                submitBtn.disabled = true;
                                submitBtn.textContent = 'Menyimpan...';
                            };

                            submitBtn.removeEventListener('click', handler);
                            submitBtn.addEventListener('click', handler, { once: true });
                        }
                    }
                });
            }

            // GLOBAL Delete Modal handling (populate and protect submit)
            var deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var destroyUrl = button.getAttribute('data-destroy-url');
                    var nama = button.getAttribute('data-surat-name') || '';
                    var jenis = button.getAttribute('data-surat-jenis') || '';

                    // populate message
                    var msgEl = deleteModal.querySelector('.delete-surat-info');
                    if (msgEl) {
                        msgEl.textContent = nama + ' (' + jenis + ')';
                    }

                    var form = deleteModal.querySelector('form');
                    if (form && destroyUrl) {
                        form.action = destroyUrl;
                        var btn = form.querySelector('button[type=submit]');
                        if (btn) {
                            // reset button state each time modal opens
                            btn.disabled = false;
                            btn.textContent = 'Ya, Hapus';
                            btn.dataset.clicked = '0';

                            // protect against double-click by disabling on first click
                            // use a click handler attached on show so it's fresh every time
                            var clickHandler = function (e) {
                                if (btn.dataset.clicked === '1') {
                                    e.preventDefault();
                                    return;
                                }
                                btn.dataset.clicked = '1';
                                btn.disabled = true;
                                btn.textContent = 'Menghapus...';
                            };

                            btn.removeEventListener('click', clickHandler);
                            btn.addEventListener('click', clickHandler, { once: true });
                        }
                    }
                });
            }

            // Minor accessibility: avoid preventing native events; use CSS to handle focus styles

            // Debug logger removed
        });
    </script>

    <!-- GLOBAL MODALS -->
    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold">Update Status Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label class="form-label fw-semibold">Pilih Status</label>
                        <select name="status" class="form-select" required>
                            <option value="diajukan">Diajukan</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">Tanggal Selesai (opsional)</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-semibold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title fw-bold text-white">Hapus Surat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-danger fw-semibold">⚠️ Anda yakin ingin menghapus surat ini?</p>
                    <p>Permintaan surat dari <strong class="delete-surat-info"></strong> akan dihapus secara permanen.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                    <form action="#" method="POST" class="delete-surat-form" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger fw-semibold">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
