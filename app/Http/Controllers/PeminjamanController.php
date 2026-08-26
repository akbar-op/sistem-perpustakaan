<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
        $anggotas = Anggota::where('aktif', true)->orderBy('nama')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('peminjamans.create', compact('anggotas', 'bukus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:anggotas,id'],
            'buku_id' => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'batas_pengembalian' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        ]);

        DB::transaction(function () use ($validated) {
            $anggota = Anggota::whereKey($validated['anggota_id'])->where('aktif', true)->firstOrFail();
            $buku = Buku::whereKey($validated['buku_id'])->lockForUpdate()->firstOrFail();

            if ($buku->stok < 1) {
                abort(422, 'Stok buku sedang habis.');
            }

            Peminjaman::create($validated + ['status' => 'dipinjam']);
            $buku->decrement('stok');
        });

        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['anggota', 'buku']);

        return view('peminjamans.show', compact('peminjaman'));
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tanggal_dikembalikan' => ['required', 'date'],
            'kondisi_buku' => ['required', Rule::in(['baik', 'rusak', 'hilang'])],
        ]);

        DB::transaction(function () use ($validated, $peminjaman) {
            $peminjaman = Peminjaman::whereKey($peminjaman->id)->lockForUpdate()->firstOrFail();
            if ($peminjaman->status !== 'dipinjam') {
                abort(422, 'Peminjaman ini sudah dikembalikan.');
            }

            $tanggalKembali = now()->parse($validated['tanggal_dikembalikan']);
            $hariTerlambat = max(0, $peminjaman->batas_pengembalian->diffInDays($tanggalKembali, false));

            $peminjaman->update([
                'tanggal_dikembalikan' => $validated['tanggal_dikembalikan'],
                'kondisi_buku' => $validated['kondisi_buku'],
                'status' => 'dikembalikan',
                'denda' => $hariTerlambat * 1000,
            ]);

            $buku = Buku::whereKey($peminjaman->buku_id)->lockForUpdate()->firstOrFail();
            $buku->increment('stok');
        });

        return redirect()->route('peminjamans.index')->with('success', 'Pengembalian berhasil dicatat.');
    }
}
