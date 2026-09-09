<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('profil', [
            'user' => $request->user(),
            'totalTransaksi' => Peminjaman::count(),
        ]);
    }
}
