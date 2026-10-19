<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function tampilLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Nama pengguna wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withInput()->withErrors([
                'username' => 'Nama pengguna atau kata sandi salah.',
            ]);
        }

        if ($user->status === 'Nonaktif') {
            return back()->withInput()->withErrors([
                'username' => 'Akun Anda dinonaktifkan. Silakan hubungi administrator lain.',
            ]);
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->filled('ingat'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withInput()->withErrors([
            'username' => 'Nama pengguna atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }

    public function tampilLupaPassword()
    {
        return view('lupa-password');
    }
}
