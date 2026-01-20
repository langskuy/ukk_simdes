@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">👥 Kelola Pengguna</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search & Filter -->
        <div class="card shadow border-0 rounded-3 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label for="search" class="form-label fw-semibold">Cari Nama atau Email</label>
                        <input type="text" name="search" id="search" class="form-control"
                            placeholder="Ketik nama atau email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="role" class="form-label fw-semibold">Filter by Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="warga" {{ request('role') === 'warga' ? 'selected' : '' }}>Warga</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-primary fw-semibold">🔍 Cari</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary fw-semibold">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-primary text-white fw-bold">Daftar Pengguna ({{ $users->total() }} Total)</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-info' }} fs-6">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info"
                                            title="Lihat Detail">👁️</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"
                                            title="Edit">✏️</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Yakin hapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Tidak ada pengguna ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users instanceof \Illuminate\Pagination\Paginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
