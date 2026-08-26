<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategoris.index', ['kategoris' => Kategori::withCount('bukus')->latest()->get()]);
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        Kategori::create($request->validate(['nama' => ['required', 'string', 'max:255', 'unique:kategoris,nama'], 'deskripsi' => ['nullable', 'string']]));

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $kategori->update($request->validate(['nama' => ['required', 'string', 'max:255', Rule::unique('kategoris', 'nama')->ignore($kategori)], 'deskripsi' => ['nullable', 'string']]));

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
