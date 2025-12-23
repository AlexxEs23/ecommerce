<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil! Selamat datang di UMKM Market.');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|unique:users,no_hp',
            'alamat' => 'required|string',
            'role' => 'required|in:user,penjual',
            'password' => 'required|min:6|confirmed'
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'alamat.required' => 'Alamat wajib diisi',
            'role.required' => 'Silakan pilih role',
            'role.in' => 'Role tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'status_approval' => $request->role === 'penjual' ? 'pending' : 'approved',
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($request->role === 'penjual') {
            return redirect('/dashboard')->with('info', 'Registrasi berhasil! Akun Anda sedang menunggu persetujuan admin. Anda bisa login namun belum bisa mengelola produk.');
        }

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di UMKM Market.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
