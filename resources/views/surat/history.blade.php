@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">📋 Riwayat Pengajuan Surat Saya</h2>
                    <a href="{{ route('surat') }}" class="btn btn-primary fw-semibold">➕ Ajukan Surat Baru</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($surats->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Selesai</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surats as $surat)
                                    <tr>
                                        <td>{{ ($surats->currentPage() - 1) * $surats->perPage() + $loop->iteration }}</td>
                                        <td><strong>{{ $surat->jenis_surat }}</strong></td>
                                        <td>
                                            @if ($surat->status === 'diajukan')
                                                <span class="badge bg-primary">Diajukan</span>
                                            @elseif ($surat->status === 'diproses')
                                                <span class="badge bg-warning">Diproses</span>
                                            @elseif ($surat->status === 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">{{ $surat->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $surat->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if ($surat->tanggal_selesai)
                                                {{ $surat->tanggal_selesai->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info btn-detail" 
                                                data-surat-id="{{ $surat->id }}" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailModal" 
                                                title="Lihat Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>

                                            @if ($surat->status === 'diajukan')
                                                <form action="{{ route('surat.cancel', $surat->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Batalkan Pengajuan">
                                                        <i class="bi bi-trash"></i> Batal
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($surat->status === 'selesai')
                                                <a href="{{ route('surat.view', $surat->id) }}" target="_blank"
                                                    class="btn btn-sm btn-primary" title="Lihat Surat">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                                <a href="{{ route('surat.download', $surat->id) }}" class="btn btn-sm btn-success"
                                                    title="Download Surat">
                                                    <i class="bi bi-download"></i> Unduh
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $surats->links() }}
                    </div>
                @else
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body text-center py-5">
                            <p class="text-muted fs-5 mb-3">Anda belum mengajukan surat apapun.</p>
                            <a href="{{ route('surat') }}" class="btn btn-primary fw-semibold">
                                ➕ Ajukan Surat Pertama Anda
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Detail (Shared untuk semua surat) -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">📋 Detail Pengajuan Surat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalDetailContent">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle Detail button click
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const suratId = this.getAttribute('data-surat-id');
                loadDetailModal(suratId);
            });
        });

        function loadDetailModal(suratId) {
            const contentDiv = document.getElementById('modalDetailContent');
            contentDiv.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
            
            fetch(`/surat/${suratId}/detail`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        contentDiv.innerHTML = buildDetailHtml(result.data);
                    } else {
                        contentDiv.innerHTML = '<div class="alert alert-danger">Gagal memuat detail</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    contentDiv.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan</div>';
                });
        }

        function buildDetailHtml(data) {
            let html = `
                <p class="mb-2"><strong>Jenis Surat:</strong> ${data.jenis_surat}</p>
                <p class="mb-2"><strong>Status:</strong> ${getStatusBadge(data.status)}</p>
                <p class="mb-2"><strong>Tanggal Pengajuan:</strong> ${data.created_at}</p>
            `;

            if (data.tanggal_selesai) {
                html += `<p class="mb-2"><strong>Tanggal Selesai:</strong> ${data.tanggal_selesai}</p>`;
            }

            // Data Warga & Pengajuan
            if (Object.keys(data.keterangan).length > 0) {
                html += `
                    <div class="mb-3">
                        <p class="mb-2"><strong>📋 Data Warga & Pengajuan:</strong></p>
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem;">
                            <table class="table table-sm table-striped mb-0">
                `;
                for (const [key, value] of Object.entries(data.keterangan)) {
                    const displayKey = key.replace(/_/g, ' ').replace(/no /gi, 'No. ');
                    const displayValue = Array.isArray(value) ? value.join(', ') : value;
                    html += `
                        <tr>
                            <td style="width: 35%; font-weight: bold; background-color: #f8f9fa;">${capitalizeFirst(displayKey)}</td>
                            <td style="width: 65%;">${displayValue}</td>
                        </tr>
                    `;
                }
                html += `
                            </table>
                        </div>
                    </div>
                `;
            }

            // Detail Data Pengajuan
            if (Object.keys(data.detail_data).length > 0) {
                html += `
                    <hr>
                    <p class="mb-2"><strong>📝 Detail Data Pengajuan:</strong></p>
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 0.375rem;">
                        <table class="table table-sm table-striped mb-0">
                `;
                for (const [key, value] of Object.entries(data.detail_data)) {
                    const displayKey = key.replace(/_/g, ' ');
                    const displayValue = Array.isArray(value) ? value.join(', ') : value;
                    html += `
                        <tr>
                            <td style="width: 35%; font-weight: bold; background-color: #f8f9fa;">${capitalizeFirst(displayKey)}</td>
                            <td style="width: 65%;">${displayValue}</td>
                        </tr>
                    `;
                }
                html += `
                        </table>
                    </div>
                `;
            }

            if (data.status === 'selesai') {
                html += `
                    <div class="alert alert-success mt-3 mb-0">
                        <i class="bi bi-check-circle"></i> Surat Anda sudah siap untuk diambil di kantor desa!
                    </div>
                `;
            }

            return html;
        }

        function getStatusBadge(status) {
            const badges = {
                'diajukan': '<span class="badge bg-primary">Diajukan</span>',
                'diproses': '<span class="badge bg-warning">Diproses</span>',
                'selesai': '<span class="badge bg-success">Selesai</span>'
            };
            return badges[status] || `<span class="badge bg-danger">${status}</span>`;
        }

        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    </script>
@endsection