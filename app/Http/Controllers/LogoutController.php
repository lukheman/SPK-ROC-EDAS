<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // contoh di controller logout
        if (auth('pengguna')->check()) {
            auth('pengguna')->logout();
        } elseif (auth('siswa')->check()) {
            auth('siswa')->logout();
        }

        // clear session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        flash('Berhasil logout dari aplikasi');

        return to_route('login');

    }
}
