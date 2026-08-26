<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RakController extends Controller
{
    public function index()
    {
        return view('raks.index', ['raks' => Rak::withCount('bukus')->latest()->get()]);
    }

    public function create()
    {
        return view('raks.create');
    }

    public function store(Request $request)
    {
        Rak::create($request->validate(['kode_rak' => ['required', 'string', 'max:255', 'unique:raks,kode_rak'], 'nama' => ['required', 'string', 'max:255'], 'lokasi' => ['nullable', 'string', 'max:255']]));

        return redirect()->route('raks.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(Rak $rak)
    {
        return view('raks.edit', compact('rak'));
    }

    public function update(Request $request, Rak $rak)
    {
        $rak->update($request->validate(['kode_rak' => ['required', 'string', 'max:255', Rule::unique('raks', 'kode_rak')->ignore($rak)], 'nama' => ['required', 'string', 'max:255'], 'lokasi' => ['nullable', 'string', 'max:255']]));

        return redirect()->route('raks.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        $rak->delete();

        return redirect()->route('raks.index')->with('success', 'Rak berhasil dihapus.');
    }
}
