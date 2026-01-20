@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Detail Pengguna: {{ $user->name }}</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="mb-2"><strong>ID:</strong> {{ $user->id }}</p>
                    <p class="mb-2"><strong>Nama:</strong> {{ $user->name }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="mb-2">
                        <strong>Role:</strong>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </p>
                    <p class="mb-2"><strong>Dibuat:</strong> {{ $user->created_at->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning w-100 mb-2">Edit Data User</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Hapus User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
