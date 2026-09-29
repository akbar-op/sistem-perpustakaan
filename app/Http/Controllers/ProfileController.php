<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        if ($request->user()->isStudent()) {
            $anggota = $request->user()->email
                ? Anggota::query()->where('email', $request->user()->email)->get(['nis_nip'])
                : collect();
            $totalTransaksi = $anggota->count() === 1 && $anggota->first()->nis_nip
                ? Peminjaman::where('nis_nip', $anggota->first()->nis_nip)->count()
                : 0;
        } else {
            $totalTransaksi = Peminjaman::count();
        }

        return view('profil', [
            'user' => $request->user(),
            'totalTransaksi' => $totalTransaksi,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->user())],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        $request->user()->update($validated);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
