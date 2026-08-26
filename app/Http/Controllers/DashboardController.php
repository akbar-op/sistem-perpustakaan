<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard', [
            'totalBuku' => Buku::count(),
            'totalStok' => Buku::sum('stok'),
            'totalAnggota' => Anggota::where('aktif', true)->count(),
            'sedangDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'terlambat' => Peminjaman::where('status', 'dipinjam')->whereDate('batas_pengembalian', '<', today())->count(),
            'peminjamansTerbaru' => Peminjaman::with(['anggota', 'buku'])->latest()->limit(10)->get(),
        ]);
    }
}
