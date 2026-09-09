@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-4 lg:px-5">
            <header class="flex items-start justify-between border-b border-[#e3e8f1] pb-4">
                <div>
                    <p class="text-xs text-[#8aa0c2]">Sistem Perpustakaan</p>
                    <p class="mt-1 text-base font-bold text-[#34445f]">Laporan</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden h-10 w-56 items-center rounded-full border border-[#4561e8] bg-white px-3 text-sm text-[#8ea0bf] sm:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-4-4"></path>
                        </svg>
                        Pencarian
                    </div>
                    <button type="button" aria-label="Notifikasi" class="relative grid h-10 w-10 place-items-center rounded-full border border-[#e1e7f1] bg-white text-[#8797b2] shadow-sm">
                        <img src="{{ asset('image/notification.png') }}" alt="" class="h-5 w-5 object-contain">
                        <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#4561e8] px-1 text-[10px] font-bold text-white">3</span>
                    </button>
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-[#2d9bd2] text-sm font-bold text-white shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <section class="mt-8">
                <h1 class="text-3xl font-bold tracking-tight text-[#202d45]">Laporan Perpustakaan</h1>
                <p class="mt-1 text-sm text-[#7b8eaf]">Lihat, cetak, dan unduh data perpustakaan</p>
            </section>

            <section class="mt-8 grid max-w-[800px] gap-4 sm:grid-cols-3" aria-label="Ringkasan laporan">
                <div class="rounded-xl border border-[#e4e9f2] bg-white px-4 py-4 shadow-[0_2px_3px_rgba(31,45,68,0.12)]">
                    <p class="text-xs font-semibold text-[#7b8eaf]">Total Buku</p>
                    <p class="mt-2 text-2xl font-bold text-[#344563]">{{ number_format($totalBuku) }}</p>
                </div>
                <div class="rounded-xl border border-[#e4e9f2] bg-white px-4 py-4 shadow-[0_2px_3px_rgba(31,45,68,0.12)]">
                    <p class="text-xs font-semibold text-[#7b8eaf]">Total Transaksi</p>
                    <p class="mt-2 text-2xl font-bold text-[#344563]">{{ number_format($totalPeminjaman) }}</p>
                </div>
                <div class="rounded-xl border border-[#e4e9f2] bg-white px-4 py-4 shadow-[0_2px_3px_rgba(31,45,68,0.12)]">
                    <p class="text-xs font-semibold text-[#7b8eaf]">Total Denda</p>
                    <p class="mt-2 text-2xl font-bold text-[#344563]">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                </div>
            </section>

            <section class="mt-12 grid max-w-[1000px] gap-5 md:grid-cols-2" aria-label="Pilihan laporan">
                @if ($canViewBookReport)
                    <article class="rounded-2xl border border-[#e4e9f2] bg-white p-5 shadow-[0_2px_3px_rgba(31,45,68,0.15)]">
                        <div class="flex items-start gap-4">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#eef3ff]">
                                <img src="{{ asset('image/book.png') }}" alt="" class="h-8 w-8 object-contain">
                            </span>
                            <div>
                                <h2 class="text-xl font-bold text-[#344563]">Laporan Buku</h2>
                                <p class="mt-1 text-sm text-[#7b8eaf]">Daftar lengkap koleksi buku, kategori, rak, dan stok.</p>
                            </div>
                        </div>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('laporan.print', 'buku') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#4561e8] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_6px_12px_rgba(69,97,232,0.2)] transition hover:bg-[#304bc3]">
                                <span aria-hidden="true">↗</span> Lihat / Cetak
                            </a>
                            <a href="{{ route('laporan.excel', 'buku') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#b3c5fa] bg-white px-4 py-2.5 text-sm font-semibold text-[#4561e8] transition hover:bg-[#f4f7ff]">
                                <span aria-hidden="true">↓</span> Export Excel
                            </a>
                        </div>
                    </article>
                @endif

                <article class="rounded-2xl border border-[#e4e9f2] bg-white p-5 shadow-[0_2px_3px_rgba(31,45,68,0.15)]">
                    <div class="flex items-start gap-4">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#eef3ff]">
                            <img src="{{ asset('image/time.png') }}" alt="" class="h-8 w-8 object-contain">
                        </span>
                        <div>
                            <h2 class="text-xl font-bold text-[#344563]">Laporan Peminjaman</h2>
                            <p class="mt-1 text-sm text-[#7b8eaf]">Riwayat peminjaman, pengembalian, status, dan denda.</p>
                        </div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('laporan.print', 'peminjaman') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#4561e8] px-4 py-2.5 text-sm font-semibold text-white shadow-[0_6px_12px_rgba(69,97,232,0.2)] transition hover:bg-[#304bc3]">
                            <span aria-hidden="true">↗</span> Lihat / Cetak
                        </a>
                        <a href="{{ route('laporan.excel', 'peminjaman') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#b3c5fa] bg-white px-4 py-2.5 text-sm font-semibold text-[#4561e8] transition hover:bg-[#f4f7ff]">
                            <span aria-hidden="true">↓</span> Export Excel
                        </a>
                    </div>
                </article>
            </section>
        </div>
    </main>
@endsection<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Laporan</title></head>
<body>
    <h1>Laporan Perpustakaan</h1>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    @if ($canViewBookReport)
        <section><h2>Laporan Buku</h2><a href="{{ route('laporan.print', 'buku') }}">Lihat / Cetak PDF</a> <a href="{{ route('laporan.excel', 'buku') }}">Export Excel</a></section>
    @endif
    <section><h2>Laporan Peminjaman</h2><a href="{{ route('laporan.print', 'peminjaman') }}">Lihat / Cetak PDF</a> <a href="{{ route('laporan.excel', 'peminjaman') }}">Export Excel</a></section>
</body>
</html>
