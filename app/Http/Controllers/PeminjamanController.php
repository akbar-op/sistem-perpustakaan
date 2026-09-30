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

    public function pinjamUntukSiswa(Request $request, Buku $buku)
    {
        $user = $request->user();
        abort_unless($user->email, 403, 'Akun belum terhubung dengan data anggota perpustakaan.');

        $settings = DB::table('library_settings')->find(1);
        $maxBooks = (int) ($settings->max_books ?? 5);
        $loanDurationDays = (int) ($settings->loan_duration_days ?? 14);
        $tanggalPinjam = today()->toDateString();
        $batasPengembalian = today()->addDays($loanDurationDays)->toDateString();

        $error = DB::transaction(function () use ($user, $buku, $maxBooks, $tanggalPinjam, $batasPengembalian) {
            $anggotas = Anggota::query()
                ->where('email', $user->email)
                ->lockForUpdate()
                ->get(['id', 'nis_nip', 'jenis_anggota', 'aktif']);

            abort_unless($anggotas->count() === 1, 403, 'Akun harus terhubung dengan tepat satu data anggota.');

            $anggota = $anggotas->first();
            abort_unless(
                $anggota->nis_nip && strcasecmp($anggota->jenis_anggota ?? '', 'siswa') === 0 && $anggota->aktif,
                403,
                'Data anggota siswa belum aktif atau belum lengkap.'
            );

            $jumlahPinjamanAktif = Peminjaman::query()
                ->where('nis_nip', $anggota->nis_nip)
                ->where('status', 'dipinjam')
                ->count();

            if ($jumlahPinjamanAktif >= $maxBooks) {
                return "Batas pinjaman aktif Anda adalah {$maxBooks} buku.";
            }

            $bukuTerkunci = Buku::query()->lockForUpdate()->findOrFail($buku->getKey());

            if ($bukuTerkunci->stok < 1) {
                return 'Stok buku ini sedang habis.';
            }

            Peminjaman::create([
                'nis_nip' => $anggota->nis_nip,
                'buku_id' => $bukuTerkunci->id,
                'tanggal_pinjam' => $tanggalPinjam,
                'batas_pengembalian' => $batasPengembalian,
                'status' => 'dipinjam',
            ]);
            $bukuTerkunci->decrement('stok');

            return null;
        });

        if ($error !== null) {
            return redirect()->route('katalog-buku.show', $buku)->with('error', $error);
        }

        return redirect()->route('peminjamans.mine')
            ->with('success', 'Buku berhasil dipinjam. Batas pengembalian: '.now()->parse($batasPengembalian)->format('d-m-Y').'.');
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
