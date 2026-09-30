<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', fn (Request $request) => redirect()->route($request->user()->isStudent() ? 'katalog-buku.index' : 'dashboard'));

    Route::middleware('role:admin,petugas,siswa')->group(function () {
        Route::get('profil', [ProfileController::class, 'show'])->name('profil');
        Route::put('profil', [ProfileController::class, 'update'])->name('profil.update');
    });

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

    Route::middleware('role:admin,kepala_sekolah')->group(function () {
        Route::get('setting', [SettingController::class, 'index'])->name('setting');
        Route::put('setting', [SettingController::class, 'update'])->name('setting.update');
    });

    Route::middleware('role:siswa')->group(function () {
        Route::get('katalog-buku', [BukuController::class, 'catalog'])
            ->name('katalog-buku.index');
        Route::get('katalog-buku/{buku}', [BukuController::class, 'show'])
            ->name('katalog-buku.show');
        Route::post('katalog-buku/{buku}/pinjam', [PeminjamanController::class, 'pinjamUntukSiswa'])
            ->name('katalog-buku.pinjam');
        Route::get('peminjaman-saya', [PeminjamanController::class, 'mine'])
            ->name('peminjamans.mine');
    });
});
