@extends('layouts.app')

@section('title', 'Verifikasi Dokumen - ' . $surat->jenis_surat)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white py-4 text-center border-0">
                        <div class="display-1 mb-3">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <h3 class="fw-bold mb-0">Dokumen Terverifikasi</h3>
                        <p class="mb-0 opacity-75">Sistem Informasi Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="p-3 bg-light rounded-3 d-inline-block mb-3">
                                <i class="bi bi-file-earmark-text text-success h1 mb-0"></i>
                            </div>
                            <h4 class="fw-bold">{{ strtoupper($surat->jenis_surat) }}</h4>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                No: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                                <span class="text-muted">Nama Pemohon</span>
                                <span class="fw-bold text-end">{{ strtoupper($surat->nama_pemohon) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                                <span class="text-muted">NIK</span>
                                <span
                                    class="fw-bold">{{ substr($surat->nik, 0, 4) . ' **** **** ' . substr($surat->nik, -4) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                                <span class="text-muted">Tanggal Diterbitkan</span>
                                <span class="fw-bold">{{ $surat->created_at->locale('id')->isoFormat('D MMMM Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                                <span class="text-muted">Status Dokumen</span>
                                <span class="badge bg-success">ASLI (ORIGINAL)</span>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 mt-4 mb-0">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                                <div>
                                    <small>Dokumen ini adalah dokumen resmi Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}
                                        yang diterbitkan secara elektronik dan memiliki kekuatan hukum yang sah.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-3 text-center border-0">
                        <a href="{{ route('beranda') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-success {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
        }

        .bg-success-subtle {
            background-color: #e8f5e9 !important;
        }

        .rounded-4 {
            border-radius: 1.5rem !important;
        }
    </style>
@endsection