<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $kategoriId = $request->integer('kategori_id') ?: null;
        $bukus = Buku::query()
            ->when($kategoriId, fn ($query) => $query->where('kategori_id', $kategoriId))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('kode_buku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $kategoris = Kategori::orderBy('nama')->get(['id', 'nama']);

        return view('bukus.index', compact('bukus', 'search', 'kategoris', 'kategoriId'));
    }

    public function catalog(Request $request)
    {
        $search = $request->string('search')->trim()->toString();
        $kategoriId = $request->integer('kategori_id') ?: null;
        $bukus = Buku::with(['kategori', 'rak'])
            ->when($kategoriId, fn ($query) => $query->where('kategori_id', $kategoriId))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('kode_buku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();
        $kategoris = Kategori::orderBy('nama')->get(['id', 'nama']);

        return view('bukus.catalog', compact('bukus', 'search', 'kategoris', 'kategoriId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bukus.create', [
            'kategoris' => Kategori::orderBy('nama')->get(),
            'raks' => Rak::orderBy('kode_rak')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Buku::create($this->validatedData($request));

        return redirect()
            ->route('bukus.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        return view('bukus.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        return view('bukus.edit', [
            'buku' => $buku,
            'kategoris' => Kategori::orderBy('nama')->get(),
            'raks' => Rak::orderBy('kode_rak')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $buku->update($this->validatedData($request, $buku));

        return redirect()
            ->route('bukus.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()
            ->route('bukus.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }

    /**
     * Validate and normalize the book payload for create and update requests.
     */
    private function validatedData(Request $request, ?Buku $buku = null): array
    {
        return $request->validate([
            'kode_buku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bukus', 'kode_buku')->ignore($buku),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1', 'max:'.now()->year],
            'isbn' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('bukus', 'isbn')->ignore($buku),
            ],
            'kategori_id' => ['nullable', 'exists:kategoris,id'],
            'rak_id' => ['nullable', 'exists:raks,id'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);
    }
}
