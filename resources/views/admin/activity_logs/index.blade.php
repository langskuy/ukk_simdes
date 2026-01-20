@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="card border-0 rounded-4 shadow-sm">
        <div
            class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Log Aktivitas Pengguna</h5>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-light border" title="Reset Filter"><i
                        class="bi bi-arrow-counterclockwise"></i></a>
                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Filter Tipe
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('admin.activity-logs.index', ['type' => 'login']) }}">Login</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('admin.activity-logs.index', ['type' => 'logout']) }}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-4 pt-0">
            <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control border-end-0 bg-light"
                        placeholder="Cari nama user, IP, atau deskripsi..." name="search" value="{{ request('search') }}">
                    <button class="btn btn-light border border-start-0 bg-light text-muted" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start">Waktu</th>
                            <th class="border-0">User</th>
                            <th class="border-0">Aktivitas</th>
                            <th class="border-0">Deskripsi</th>
                            <th class="border-0">IP Address</th>
                            <th class="border-0 rounded-end">User Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="text-muted small" style="white-space: nowrap;">
                                    {{ $log->created_at->format('d M Y H:i:s') }}</td>
                                <td>
                                    @if($log->user)
                                        <div class="fw-bold">{{ $log->user->name }}</div>
                                        <small class="text-muted">{{ $log->user->role }}</small>
                                    @else
                                        <span class="text-muted fst-italic">User Terhapus</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->activity_type == 'login')
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">LOGIN</span>
                                    @elseif($log->activity_type == 'logout')
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">LOGOUT</span>
                                    @else
                                        <span class="badge bg-light text-dark border">{{ $log->activity_type }}</span>
                                    @endif
                                </td>
                                <td>{{ $log->description }}</td>
                                <td class="font-monospace small">{{ $log->ip_address }}</td>
                                <td>
                                    <div class="text-truncate text-muted small" style="max-width: 200px;"
                                        title="{{ $log->user_agent }}">
                                        {{ $log->user_agent }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-shield-check fs-1 d-block mb-3 opacity-25"></i>
                                    Belum ada aktivitas tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection