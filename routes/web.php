<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', fn () => redirect()->route('dashboard'));

    Route::middleware('role:admin,petugas,kepala_sekolah')->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('{type}/print', [ReportController::class, 'print'])->name('print');
            Route::get('{type}/excel', [ReportController::class, 'excel'])->name('excel');
        });
    });

    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('bukus', BukuController::class);
        Route::resource('anggotas', AnggotaController::class)->except(['show']);
        Route::resource('peminjamans', PeminjamanController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('peminjamans/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
            ->name('peminjamans.kembalikan');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('kategoris', KategoriController::class)->except(['show']);
        Route::resource('raks', RakController::class)->except(['show']);
    });
});
