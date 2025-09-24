<?php

use Illuminate\Support\Facades\Route;
use App\Livewire as Livewire;
use App\Http\Controllers as Controllers;

// =======================
// Public Routes
// =======================
Route::get('/', Livewire\Landing::class)->name('landing');
Route::get('/tentang-kami', Livewire\AboutUs::class)->name('about-us');

// Authentication
Route::get('/login', Livewire\Login::class)->name('login')->middleware('guest');
Route::get('/logout', Controllers\LogoutController::class)->name('logout');

Route::get('/konsultasi', Livewire\Diagnosis\Flow::class)->name('konsultasi');

Route::get('/daftar-penyakit', Livewire\DaftarPenyakit::class)->name('daftar-penyakit');

// =======================
// Authenticated Routes
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', Livewire\Profile::class)->name('profile');
    Route::get('/dashboard', Livewire\Dashboard::class)->name('dashboard');

    // Master Data
    Route::get('/penyakit', Livewire\PenyakitTable::class)->name('penyakit-table');
    Route::get('/gejala', Livewire\GejalaTable::class)->name('gejala-table');
    Route::get('/rule', Livewire\RuleTable::class)->name('rule-table');

    // Riwayat
    Route::get('/riwayat-konsultasi', Livewire\RiwayatKonsultasiTable::class)
        ->name('riwayat-konsultasi-table');

    // Laporan
    Route::prefix('laporan')
        ->controller(Controllers\LaporanController::class)
        ->group(function () {
            Route::get('/riwayat-konsultasi', 'riwayatKonsultasi')
                ->name('laporan-riwayat-konsultasi');

            Route::get('/riwayat-konsultasi/{id}', 'riwayatKonsultasiSatu')
                ->name('laporan-riwayat-konsultasi-satu');
        });

});
