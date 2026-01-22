<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman register.
     */
    public function registerForm()
    {
        // dd('ok');
        return view('auth.register');
    }

    /**
     * Proses register user baru.
     */
    public function registerStore(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nik' => 'required|numeric|digits:16|unique:users,nik',
            'tanggal_lahir' => 'required|date|before:' . now()->subYears(17)->format('Y-m-d'),
            'password' => 'required|string|min:6|confirmed',
        ], [
            'tanggal_lahir.before' => 'Anda harus minimal berusia 17 tahun untuk mendaftar.',
        ]);

        // Cek validitas data warga (Master Data)
        $penduduk = \App\Models\Penduduk::where('nik', $validated['nik'])->first();

        if (!$penduduk) {
            return back()->withErrors(['nik' => 'NIK tidak terdaftar dalam database penduduk desa.'])->withInput();
        }

        // Cek kesesuaian nama (case-insensitive)
        if (strcasecmp($validated['name'], $penduduk->nama) != 0) {
            return back()->withErrors(['name' => 'Nama tidak sesuai dengan data penduduk untuk NIK tersebut.'])->withInput();
        }

        // Buat user baru
        // `User` model has a `hashed` cast for `password`, so pass the
        // raw password here and let the model cast/hash it.
        $user = User::create([
            'name' => $penduduk->nama, // Gunakan nama dari master data untuk konsistensi
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'password' => $validated['password'],
            'role' => 'warga',
        ]);

        // Do NOT auto-login after register — require explicit login
        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan masuk menggunakan akun Anda.');
    }

    /**
     * Tampilkan halaman login.
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function loginAttempt(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('warga.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    /**
     * Tampilkan halaman login admin.
     */
    public function adminLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Proses login admin.
     */
    public function adminLoginAttempt(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Maaf, akun ini tidak memiliki akses administrator.'])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau password administrator salah.'])
            ->withInput();
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect users to the public homepage (beranda) after logout
        return redirect()->route('beranda')->with('success', 'Anda berhasil logout.');
    }
}
