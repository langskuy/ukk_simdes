<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:admin') or ->middleware('role:admin,warga')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form');
        }

        // If no roles specified, allow authenticated users
        if (empty($roles)) {
            return $next($request);
        }

        // Roles may be passed as a single comma-separated string
        if (count($roles) === 1 && strpos($roles[0], ',') !== false) {
            $roles = array_map('trim', explode(',', $roles[0]));
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // If request expects JSON (AJAX), return a JSON 403 response
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // Otherwise, redirect back to warga dashboard with a friendly message
        return redirect()->route('warga.dashboard')->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk halaman ini.');
    }
}

