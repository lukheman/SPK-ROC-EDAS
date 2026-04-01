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
        if(auth('admin')->check()) {
            auth('admin')->logout();
        }elseif (auth('siswa')->check()) {
            auth('siswa')->logout();
        } elseif(auth('kepala_sekolah')->check()) {
            auth('kepala_sekolah')->logout();
        }

        // clear session
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        flash('Berhasil logout dari aplikasi');

        return to_route('login');

    }
}
