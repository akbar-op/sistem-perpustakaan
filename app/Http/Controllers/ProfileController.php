<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __invoke(): View
    {
        return view('profil', [
            'user' => auth()->user(),
            'totalTransaksi' => Peminjaman::count(),
        ]);
    }
}
