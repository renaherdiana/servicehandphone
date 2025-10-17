<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** 🔹 Tampilkan halaman login */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /** 🔹 Proses login */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Ambil user aktif pertama berdasarkan urutan pembuatan
        $activeUser = User::where('status', 'active')->orderBy('created_at', 'asc')->first();

        if (!$activeUser) {
            return back()->withErrors(['email' => 'Tidak ada akun aktif yang tersedia.']);
        }

        // Cek apakah user yang dimasukkan sesuai dengan user aktif pertama
        if ($request->email !== $activeUser->email) {
            return back()->withErrors(['email' => 'Hanya akun aktif pertama yang dapat login.']);
        }

        // Verifikasi password
        if (!Hash::check($request->password, $activeUser->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        // Login user aktif pertama
        Auth::login($activeUser);

        return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $activeUser->name . '!');
    }

    /** 🔹 Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
