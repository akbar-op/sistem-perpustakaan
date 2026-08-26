<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $anggotas = Anggota::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('nomor_anggota', 'like', "%{$search}%")
                        ->orWhere('nis_nip', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('anggotas.index', compact('anggotas', 'search'));
    }

    public function create()
    {
        return view('anggotas.create');
    }

    public function store(Request $request)
    {
        Anggota::create($this->validatedData($request));

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggota)
    {
        return view('anggotas.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $anggota->update($this->validatedData($request, $anggota));

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->peminjamans()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', 'Anggota masih memiliki buku yang dipinjam.');
        }

        $anggota->delete();

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Anggota $anggota = null): array
    {
        return $request->validate([
            'nomor_anggota' => ['required', 'string', 'max:255', Rule::unique('anggotas', 'nomor_anggota')->ignore($anggota)],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_anggota' => ['required', Rule::in(['siswa', 'guru'])],
            'nis_nip' => ['nullable', 'string', 'max:255', Rule::unique('anggotas', 'nis_nip')->ignore($anggota)],
            'kelas' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:30'],
            'aktif' => ['sometimes', 'boolean'],
        ]);
    }
}
