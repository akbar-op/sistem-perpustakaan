@extends('layout.index')
@section('content')

        <main class="w-full lg:ml-64"><div class="mx-auto max-w-[1440px] px-5 py-5 sm:px-8 lg:px-8">
            <header class="flex min-h-16 items-start justify-between border-b border-[#e3e8f1] pb-4"><div><p class="text-[11px] text-[#8092b3]">Sistem Perpustakaan</p><h1 class="mt-1 text-base font-bold text-[#30415e]">Dashboard</h1></div><div class="flex items-center gap-3"><div class="hidden h-10 w-56 items-center rounded-full border border-[#8ea3ff] px-3 text-sm text-[#9aa9c5] sm:flex"><span class="mr-2 text-lg">⌕</span>Pencarian</div><button type="button" aria-label="Notifikasi" class="relative grid h-10 w-10 place-items-center rounded-full border border-[#e1e7f1] bg-white text-lg text-[#8797b2]"><span class="grid h-9 w-9 place-items-center overflow-hidden rounded bg-blue"><img src="{{ asset('image/notification.png') }}" alt="Logo Notifikasi" class="h-full w-full object-contain p-1"></span><span class="absolute right-0 top-0 grid h-4 min-w-4 place-items-center rounded-full bg-[#4561e8] px-1 text-[9px] font-bold text-white">3</span></button><div class="grid h-10 w-10 place-items-center rounded-full bg-[#2d9bd2] text-lg font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div></div></header>
            <div class="mt-8"><h2 class="text-3xl font-bold tracking-tight text-[#1f2d44]">Dashboard</h2><p class="mt-1 text-sm text-[#5d7396]">Selamat datang, Apa yang ingin kamu ketahui hari ini.</p></div>

                <section class="mt-14" aria-labelledby="statistik-title"><h2 id="statistik-title" class="sr-only">Statistik perpustakaan</h2><div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['Total Anggota', $totalAnggota, 'user.png'],
                        ['Total judul buku', $totalBuku, 'book.png'],
                        ['Buku Kembali', $bukuKembali, 'arrow-down.png'],
                        ['Buku di Pinjam', $sedangDipinjam, 'arrow-up.png'],
                    ] as $stat)
                        <div class="flex min-h-[112px] items-center gap-3 rounded-xl border border-[#e6e9ef] bg-white px-3 shadow-[0_2px_3px_rgba(31,45,68,0.22)]">
                            <span class="grid h-14 w-14 shrink-0 place-items-center rounded-lg bg-[#4561e8]">
                            <img
                                src="{{ asset('image/' . $stat[2]) }}"
                                alt="{{ $stat[0] }}"
                                class="h-10 w-10 object-contain">
                            </span>
                            <div><p class="text-xs font-semibold text-[#7183a2]">{{ $stat[0] }}</p><p class="mt-2 text-2xl font-bold text-[#344563]">{{ number_format($stat[1]) }}</p></div></div>
                    @endforeach
                </div></section>

                <section class="mt-16 grid grid-cols-1 gap-7 xl:grid-cols-[1.65fr_1fr]" aria-label="Ringkasan transaksi dan grafik"><div class="overflow-hidden rounded-2xl border border-[#e6e9ef] bg-white shadow-[0_2px_3px_rgba(31,45,68,0.2)]"><div class="flex items-center justify-between px-5 pb-2 pt-3"><h2 id="transaksi-title" class="text-xl font-bold text-[#30415e]">Transaksi Terakhir</h2><a href="{{ route('laporan.index') }}" class="text-xs font-semibold text-[#4561e8] hover:text-[#304bc3]">Lihat Semua</a></div><div class="overflow-x-auto"><table class="w-full min-w-[600px] text-left"><tbody class="text-sm">@forelse ($peminjamansTerbaru as $peminjaman)<tr class="transition hover:bg-[#fbfcff]"><td class="w-8 px-4 py-2 font-semibold text-[#30415e]">{{ $loop->iteration }}.</td><td class="w-36 px-2 py-2 font-bold text-[#30415e]">{{ $peminjaman->anggota->nama }}</td><td class="max-w-[190px] px-2 py-2 text-xs font-bold leading-tight text-[#30415e]">{{ $peminjaman->buku->judul }}</td><td class="px-4 py-2 text-sm font-bold capitalize text-[#30415e]">{{ $peminjaman->status }}</td></tr>@empty<tr><td colspan="4" class="px-6 py-12 text-center text-sm text-[#8b98b1]">Belum ada transaksi.</td></tr>@endforelse</tbody></table></div></div>
                @php($chartMax = max($totalStok, $bukuKembali, $sedangDipinjam, 1))
                <div class="rounded-2xl bg-[#d9d9d9] px-5 pb-3 pt-3 shadow-[0_2px_3px_rgba(31,45,68,0.2)]"><h2 id="grafik-title" class="text-xl font-bold text-[#30415e]">Grafik</h2><div class="mt-5 grid grid-cols-[30px_1fr] gap-3"><div class="flex h-56 flex-col justify-between pb-5 text-sm font-bold text-[#30415e]"><span>100</span><span>75</span><span>50</span><span>25</span><span>0</span></div><div class="flex h-56 items-end justify-around gap-4 border-b border-[#bcbcbc] px-2"><div class="flex h-full flex-col items-center justify-end gap-2"><div class="w-6 rounded-t-sm bg-[#4561e8] {{ $bukuKembali >= $chartMax * .66 ? 'h-44' : ($bukuKembali >= $chartMax * .33 ? 'h-32' : 'h-20') }}"></div><span class="text-xs text-[#607391]">Jan</span></div><div class="flex h-full flex-col items-center justify-end gap-2"><div class="w-6 rounded-t-sm bg-[#4561e8] {{ $sedangDipinjam >= $chartMax * .66 ? 'h-44' : ($sedangDipinjam >= $chartMax * .33 ? 'h-32' : 'h-20') }}"></div><span class="text-xs text-[#607391]">Feb</span></div><div class="flex h-full flex-col items-center justify-end gap-2"><div class="w-6 rounded-t-sm bg-[#4561e8] {{ $totalStok >= $chartMax * .66 ? 'h-44' : ($totalStok >= $chartMax * .33 ? 'h-32' : 'h-20') }}"></div><span class="text-xs text-[#607391]">Mar</span></div></div></div></div></div>
                @if (auth()->user()->isPrincipal())
                    <section class="mt-10 rounded-2xl border border-[#e6e9ef] bg-white p-5 shadow-[0_2px_3px_rgba(31,45,68,0.2)]">
                        <h2 class="text-xl font-bold text-[#30415e]">Laporan Peminjaman</h2>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('laporan.print', 'peminjaman') }}" class="rounded-xl border border-[#dfe7f5] bg-[#f5f8ff] px-4 py-2 text-sm font-semibold text-[#2d4ab4] hover:bg-[#ebf1ff]">
                                Lihat / Cetak PDF
                            </a>
                            <a href="{{ route('laporan.excel', 'peminjaman') }}" class="rounded-xl border border-[#dfe7f5] bg-white px-4 py-2 text-sm font-semibold text-[#30415e] hover:bg-[#f7f9fc]">
                                Export Excel
                            </a>
                        </div>
                    </section>
                @endif

                <footer class="mt-8 text-center text-xs text-[#9aa6ba]">LibraMS &middot; Sistem manajemen perpustakaan</footer>
            </div>
        </main>

@endsection