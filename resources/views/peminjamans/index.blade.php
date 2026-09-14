@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-6 lg:px-8">
            <header class="flex items-center justify-end border-b border-[#e3e8f1] pb-4">
                <div class="flex items-center gap-3">
                    @include('layout.search')
                    <button type="button" aria-label="Notifikasi" class="relative grid h-10 w-10 place-items-center rounded-full border border-[#e1e7f1] bg-white text-lg text-[#8797b2] shadow-sm">
                        <img src="{{ asset('image/notification.png') }}" alt="Notifikasi" class="h-5 w-5 object-contain">
                        <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#4561e8] px-1 text-[10px] font-bold text-white">3</span>
                    </button>
                    @include('layout.theme-toggle')
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-[#2d9bd2] text-sm font-bold text-white shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="mt-8">
                <h2 class="text-4xl font-bold tracking-tight text-[#1f2d44]">Pengembalian Buku</h2>
                <p class="mt-1 text-sm text-[#5d7396]">Memproses buku yg sudah di kembalikan</p>
            </div>

            <div class="mt-8 max-w-[980px]">
                <div class="mb-4 flex items-center gap-3">
                    <h3 class="text-lg font-bold text-[#1f2d44]">Pengembalian yg aktif</h3>
                    <span class="inline-flex rounded-full bg-[#eef3ff] px-2.5 py-1 text-xs font-semibold text-[#4561e8]">{{ $peminjamans->total() }}</span>
                </div>

                <form action="{{ route('peminjamans.index') }}" method="GET" class="rounded-[18px] border border-[#dfe7f5] bg-white px-4 py-3 shadow-[0_2px_6px_rgba(69,97,232,0.08)]">
                    <div class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-[#f3f7ff] text-[#4561e8]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="6"></circle>
                                <path d="m16 16 4.5 4.5"></path>
                            </svg>
                        </span>
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Cari..."
                            class="w-full border-0 bg-transparent text-base text-[#2a3b53] placeholder:text-[#8b99b5] focus:outline-none focus:ring-0"
                        >
                    </div>
                </form>

                <div class="mt-6 space-y-4">
                    @forelse ($peminjamans as $peminjaman)
                        @php
                            $terlambat = $peminjaman->batas_pengembalian?->lt(today()) ?? false;
                            $hariTerlambat = $terlambat ? $peminjaman->batas_pengembalian->diffInDays(today()) : 0;
                            $estimasiDenda = $hariTerlambat * 1000;
                        @endphp
                        <div class="flex items-center justify-between gap-6 rounded-[18px] border border-[#e1e7f1] bg-white px-4 py-4 shadow-[0_2px_6px_rgba(31,45,68,0.04)]">
                            <div class="min-w-0 flex-1">
                                <div class="text-[17px] font-bold text-[#2a3b53]">{{ $peminjaman->anggota?->nama ?? '-' }}</div>
                                <div class="mt-1 text-[15px] text-[#536b8a]">{{ $peminjaman->buku?->judul ?? 'Buku tidak ditemukan' }}</div>
                                <div class="mt-2 text-sm text-[#6c7d98]">
                                    Pinjam: {{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                                    &nbsp;•&nbsp;
                                    Batas Pinjam: {{ $peminjaman->batas_pengembalian?->format('d-m-Y') ?? '-' }}
                                </div>
                                @if ($terlambat)
                                    <div class="mt-2 text-sm font-semibold text-[#d14b4b]">
                                        Terlambat {{ $hariTerlambat }} hari
                                    </div>
                                @endif
                            </div>

                            <div class="flex shrink-0 flex-wrap items-center justify-end gap-3">
                                <button type="button" class="rounded-full border border-[#99b4ff] bg-[#f4f7ff] px-4 py-2 text-sm font-semibold text-[#4561e8]">
                                    Dipinjam
                                </button>
                                @if ($terlambat)
                                    <a href="{{ route('peminjamans.show', $peminjaman) }}" class="rounded-full border border-[#f0a0a0] bg-[#fff2f2] px-4 py-2 text-sm font-semibold text-[#c63f3f] transition hover:bg-[#ffe3e3]">
                                        Denda Rp {{ number_format($estimasiDenda, 0, ',', '.') }}
                                    </a>
                                @endif
                                <a href="{{ route('peminjamans.show', $peminjaman) }}" class="rounded-full border border-[#99b4ff] bg-[#4561e8] px-4 py-2 text-sm font-semibold text-white shadow-[0_6px_12px_rgba(69,97,232,0.2)] transition hover:bg-[#304bc3]">
                                    Kembali
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[18px] border border-dashed border-[#dfe7f5] bg-white px-6 py-12 text-center text-[#5d7396]">
                            Belum ada data pengembalian aktif.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
