<?php

use App\Http\Middleware\MultiAuth;
use Illuminate\Support\Facades\Route;
use App\Livewire as Livewire;
use App\Http\Controllers as Controllers;

// =======================
// Public Routes
// =======================
Route::get('/', Livewire\Landing::class)->name('landing');

// Authentication
Route::get('/login', Livewire\Login::class)->name('login')->middleware('guest');

Route::get('/logout', Controllers\LogoutController::class)->name('logout');

// =======================
// Authenticated Routes
// =======================
Route::middleware(MultiAuth::class . ':siswa,admin,kepala_sekolah')->group(function () {
    Route::get('/profile', Livewire\Profile\Index::class)->name('profile');
    Route::get('/dashboard', Livewire\Dashboard::class)->name('dashboard');

    // Master Data
    Route::get('/pengguna', Livewire\Table\PenggunaTable::class)->name('pengguna-table');
    Route::get('/siswa', Livewire\Table\SiswaTable::class)->name('siswa-table');
    Route::get('/siswa/export', [Controllers\SiswaExcelController::class, 'export'])->name('siswa-export');
    Route::get('/siswa/template', [Controllers\SiswaExcelController::class, 'template'])->name('siswa-template');
    Route::post('/siswa/import', [Controllers\SiswaExcelController::class, 'import'])->name('siswa-import');
    Route::get('/ranking', Livewire\Table\Ranking::class)->name('ranking');
    Route::get('/alternatif', Livewire\Table\AlternatifTable::class)->name('alternatif');
    Route::get('/kriteria', Livewire\Table\KriteriaTable::class)->name('kriteria');

    Route::get('/hasil-seleksi', Livewire\HasilSeleksi::class)->name('hasil-seleksi');

    Route::get('/laporan-hasil-seleksi',Livewire\Laporan\LaporanHasilSeleksi::class)->name('laporan-hasil-seleksi-page'); // Laporan

    Route::prefix('laporan')
        ->controller(Controllers\LaporanController::class)
        ->group(function () {
            Route::get('/laporan-hasil-seleksi', 'hasilSeleksi')
                ->name('laporan-hasil-seleksi');

        });

});
