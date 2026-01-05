@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body text-center">
                    <h3 class="text-success">Terima kasih!</h3>
                    <p class="lead">Pengaduan Anda telah dikirim. Tim administrasi desa akan meninjau dan menindaklanjuti.</p>
                    <a href="{{ route('pengaduan.history') }}" class="btn btn-primary">Lihat Riwayat Pengaduan</a>
                    <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
