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
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat user baru
            // `User` model has a `hashed` cast for `password`, so pass the
            // raw password here and let the model cast/hash it.
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'warga',
            ]);

        // Do NOT auto-login after register — require explicit login
        return redirect()
            ->route('login.form')
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

            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('warga.dashboard'),
            };
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
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
