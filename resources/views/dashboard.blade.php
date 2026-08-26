<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>

    @fonts

            @vite(['resources/css/app.css', 'resources/js/app.js'])
            
</head>
<body class="min-h-full bg-[#f4f7fc] text-[#14213d]">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="flex w-full shrink-0 flex-col bg-[#4161e8] px-6 py-6 text-white lg:fixed lg:inset-y-0 lg:w-72 lg:px-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-xl font-bold tracking-tight"><span class="grid h-10 w-10 place-items-center rounded-xl bg-white/15 text-sm font-black">LM</span>LibraMS</a>
            <div class="mt-12 rounded-2xl bg-white/10 p-4"><p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-100">Administrator Portal</p><p class="mt-3 text-sm font-semibold">Perpustakaan sekolah</p><p class="mt-1 text-xs text-blue-100">Kelola koleksi dan peminjaman</p></div>
            <nav class="mt-8 flex flex-wrap gap-2 lg:block lg:space-y-2" aria-label="Navigasi utama">
                <a href="{{ route('dashboard') }}" class="block rounded-xl bg-white px-4 py-3 text-sm font-semibold text-[#4161e8]">Ringkasan</a>
                <a href="{{ route('laporan.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">Laporan Peminjaman</a>
                @if (! auth()->user()->isPrincipal())
                    <a href="{{ route('bukus.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">Buku</a>
                    <a href="{{ route('anggotas.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">Anggota</a>
                    <a href="{{ route('peminjamans.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">Peminjaman</a>
                @endif
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('kategoris.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">Kategori</a>
                    <a href="{{ route('raks.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-blue-100 transition hover:bg-white/10 hover:text-white">Rak</a>
                @endif
            </nav>
            <div class="mt-auto hidden border-t border-white/15 pt-5 lg:block"><p class="truncate text-sm font-semibold">{{ auth()->user()->name }}</p><p class="mt-1 text-xs capitalize text-blue-100">{{ str_replace('_', ' ', auth()->user()->role) }}</p><form class="mt-4" action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="w-full rounded-xl border border-white/20 px-4 py-2.5 text-left text-sm font-medium text-blue-50 transition hover:bg-white/10">Keluar</button></form></div>
        </aside>

        <main class="w-full lg:ml-72">
            <div class="mx-auto max-w-7xl px-5 py-7 sm:px-8 lg:px-12 lg:py-10">
                <header class="flex flex-col gap-5 border-b border-[#dce3f0] pb-7 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-sm font-semibold text-[#4161e8]">Rabu, 26 Agustus 2026</p><h1 class="mt-2 text-3xl font-bold tracking-tight text-[#14213d] sm:text-4xl">Selamat datang kembali.</h1><p class="mt-2 text-sm text-[#71809d]">Berikut kondisi perpustakaan hari ini.</p></div><div class="flex items-center gap-3"><div class="grid h-11 w-11 place-items-center rounded-full bg-[#e2e8ff] text-sm font-bold text-[#4161e8]">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><div class="hidden sm:block"><p class="text-sm font-semibold">{{ auth()->user()->name }}</p><p class="mt-1 text-xs capitalize text-[#71809d]">{{ str_replace('_', ' ', auth()->user()->role) }}</p></div><form class="sm:hidden" action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="rounded-lg border border-[#dce3f0] px-3 py-2 text-xs font-semibold text-[#4161e8]">Keluar</button></form></div></header>

                <section class="mt-8" aria-labelledby="statistik-title"><div class="mb-4 flex items-center justify-between"><h2 id="statistik-title" class="text-lg font-bold">Ikhtisar perpustakaan</h2><span class="text-xs font-medium text-[#8b98b1]">Data terkini</span></div><div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
                    @foreach ([['Total judul buku', $totalBuku, 'Koleksi'], ['Stok tersedia', $totalStok, 'Siap dipinjam'], ['Anggota aktif', $totalAnggota, 'Terdaftar'], ['Sedang dipinjam', $sedangDipinjam, 'Berjalan'], ['Terlambat', $terlambat, 'Perlu perhatian']] as $stat)
                        <div class="rounded-2xl border border-[#e0e6f0] bg-white p-5 shadow-[0_8px_24px_rgba(41,62,115,0.05)]"><div class="flex items-center justify-between"><p class="text-xs font-semibold uppercase tracking-wide text-[#7c8aa5]">{{ $stat[0] }}</p><span class="h-2 w-2 rounded-full {{ $loop->last ? 'bg-[#f28b73]' : 'bg-[#4161e8]' }}"></span></div><p class="mt-4 text-3xl font-bold tracking-tight text-[#14213d]">{{ number_format($stat[1]) }}</p><p class="mt-1 text-xs text-[#8b98b1]">{{ $stat[2] }}</p></div>
                    @endforeach
                </div></section>

                <section class="mt-8 overflow-hidden rounded-2xl border border-[#e0e6f0] bg-white shadow-[0_8px_24px_rgba(41,62,115,0.05)]" aria-labelledby="transaksi-title"><div class="flex flex-col gap-2 border-b border-[#edf0f5] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6"><div><h2 id="transaksi-title" class="text-lg font-bold">Transaksi terbaru</h2><p class="mt-1 text-xs text-[#8b98b1]">Aktivitas peminjaman paling baru</p></div><a href="{{ route('laporan.index') }}" class="text-sm font-semibold text-[#4161e8] hover:text-[#304bc3]">Lihat laporan &rarr;</a></div><div class="overflow-x-auto"><table class="w-full min-w-[640px] text-left"><thead class="bg-[#f8faff] text-[11px] uppercase tracking-[0.12em] text-[#8b98b1]"><tr><th class="px-6 py-4 font-semibold">Anggota</th><th class="px-6 py-4 font-semibold">Buku</th><th class="px-6 py-4 font-semibold">Status</th><th class="px-6 py-4 font-semibold">Batas kembali</th></tr></thead><tbody class="divide-y divide-[#edf0f5] text-sm">@forelse ($peminjamansTerbaru as $peminjaman)<tr class="transition hover:bg-[#fbfcff]"><td class="px-6 py-4 font-semibold text-[#263653]">{{ $peminjaman->anggota->nama }}</td><td class="px-6 py-4 text-[#667590]">{{ $peminjaman->buku->judul }}</td><td class="px-6 py-4"><span class="rounded-full bg-[#e8edff] px-3 py-1 text-xs font-semibold capitalize text-[#4161e8]">{{ $peminjaman->status }}</span></td><td class="px-6 py-4 text-[#667590]">{{ $peminjaman->batas_pengembalian->format('d M Y') }}</td></tr>@empty<tr><td colspan="4" class="px-6 py-12 text-center text-sm text-[#8b98b1]">Belum ada transaksi.</td></tr>@endforelse</tbody></table></div></section>
                <footer class="mt-8 text-center text-xs text-[#9aa6ba]">LibraMS &middot; Sistem manajemen perpustakaan</footer>
            </div>
        </main>
    </div>
</body>
</html>
