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
        $search = trim((string) $request->input('search', ''));
        $status = $request->string('status', 'dipinjam')->toString();
        abort_unless(in_array($status, ['dipinjam', 'dikembalikan'], true), 404);

        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->where('status', $status)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('anggota', fn ($anggotaQuery) => $anggotaQuery->where('nama', 'like', "%{$search}%"))
                        ->orWhereHas('buku', fn ($bukuQuery) => $bukuQuery->where('judul', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peminjamans.index', compact('peminjamans', 'search', 'status'));
    }

    public function mine(Request $request)
    {
        abort_unless($request->user()->email, 403, 'Akun belum terhubung dengan data anggota perpustakaan.');

        $anggota = Anggota::query()
            ->where('email', $request->user()->email)
            ->get(['nis_nip']);
        abort_unless($anggota->count() === 1 && $anggota->first()->nis_nip, 403, 'Akun belum terhubung dengan satu data anggota.');

        $status = $request->string('status', 'dipinjam')->toString();
        abort_unless(in_array($status, ['dipinjam', 'dikembalikan'], true), 404);

        $peminjamans = Peminjaman::with('buku')
            ->where('status', $status)
            ->where('nis_nip', $anggota->first()->nis_nip)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peminjamans.mine', compact('peminjamans', 'status'));
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
            'anggota_id' => ['nullable', 'exists:anggotas,id'],
            'nis_nip' => ['nullable', 'exists:anggotas,nis_nip'],
            'buku_id' => ['required', 'exists:bukus,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'batas_pengembalian' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        ]);

        $anggotaNis = $validated['nis_nip'] ?? Anggota::findOrFail($validated['anggota_id'] ?? null)->nis_nip;

        DB::transaction(function () use ($validated, $anggotaNis) {
            $anggota = Anggota::where('nis_nip', $anggotaNis)->where('aktif', true)->firstOrFail();
            $buku = Buku::whereKey($validated['buku_id'])->lockForUpdate()->firstOrFail();

            if ($buku->stok < 1) {
                abort(422, 'Stok buku sedang habis.');
            }

            Peminjaman::create([
                'nis_nip' => $anggota->nis_nip,
                'buku_id' => $buku->id,
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'batas_pengembalian' => $validated['batas_pengembalian'],
                'status' => 'dipinjam',
            ]);
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

        return redirect()->route('peminjamans.index', ['status' => 'dikembalikan'])
            ->with('success', 'Pengembalian berhasil dicatat.');
    }
}
