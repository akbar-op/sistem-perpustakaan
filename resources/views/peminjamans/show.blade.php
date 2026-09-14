@extends('layout.index')

@section('content')
    @php
        $isActive = $peminjaman->status === 'dipinjam';
    @endphp

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

            <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-[#4561e8]">Transaksi Perpustakaan</p>
                    <h1 class="mt-1 text-4xl font-bold tracking-tight text-[#1f2d44]">Detail Peminjaman</h1>
                </div>
                <a href="{{ route('peminjamans.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#dfe7f5] bg-white px-4 py-2.5 text-sm font-semibold text-[#30415e] shadow-sm transition hover:bg-[#f3f7ff]">
                    <span aria-hidden="true">&larr;</span>
                    Kembali ke peminjaman
                </a>
            </div>

            <section class="mt-8 grid max-w-[1100px] gap-6 lg:grid-cols-[1.1fr_0.9fr]" aria-labelledby="detail-peminjaman-title">
                <div class="rounded-[24px] border border-[#dfe7f5] bg-white p-6 shadow-[0_4px_14px_rgba(31,45,68,0.07)] sm:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-4 border-b border-[#edf0f5] pb-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#6f7f9d]">Ringkasan Transaksi</p>
                            <h2 id="detail-peminjaman-title" class="mt-2 text-2xl font-bold text-[#1f2d44]">{{ $peminjaman->buku->judul }}</h2>
                            <p class="mt-1 text-sm text-[#5d7396]">Dipinjam oleh {{ $peminjaman->anggota->nama }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $isActive ? 'bg-[#eef3ff] text-[#4561e8]' : 'bg-emerald-50 text-emerald-700' }}">
                            {{ $isActive ? 'Sedang Dipinjam' : 'Sudah Dikembalikan' }}
                        </span>
                    </div>

                    <dl class="mt-6 grid gap-x-8 gap-y-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Anggota</dt>
                            <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $peminjaman->anggota->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Buku</dt>
                            <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $peminjaman->buku->judul }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Tanggal Pinjam</dt>
                            <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Batas Pengembalian</dt>
                            <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $peminjaman->batas_pengembalian->format('d-m-Y') }}</dd>
                        </div>
                    </dl>

                    @if (! $isActive)
                        <div class="mt-8 grid gap-5 border-t border-[#edf0f5] pt-6 sm:grid-cols-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Dikembalikan</p>
                                <p class="mt-1 font-semibold text-[#30415e]">{{ $peminjaman->tanggal_dikembalikan?->format('d-m-Y') ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Kondisi Buku</p>
                                <p class="mt-1 font-semibold capitalize text-[#30415e]">{{ $peminjaman->kondisi_buku ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Denda</p>
                                <p class="mt-1 font-semibold text-[#c63f3f]">Rp {{ number_format($peminjaman->denda ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($isActive)
                    <div class="rounded-[24px] border border-[#dfe7f5] bg-white p-6 shadow-[0_4px_14px_rgba(31,45,68,0.07)] sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#6f7f9d]">Aksi Transaksi</p>
                        <h2 class="mt-2 text-2xl font-bold text-[#1f2d44]">Catat Pengembalian</h2>
                        <p class="mt-2 text-sm leading-6 text-[#5d7396]">Periksa kondisi buku sebelum menyimpan pengembalian.</p>

                        <form action="{{ route('peminjamans.kembalikan', $peminjaman) }}" method="POST" class="mt-6 space-y-5">
                            @csrf
                            <div>
                                <label for="tanggal_dikembalikan" class="mb-2 block text-sm font-semibold text-[#30415e]">Tanggal Dikembalikan</label>
                                <input type="date" id="tanggal_dikembalikan" name="tanggal_dikembalikan" value="{{ today()->toDateString() }}" required class="h-11 w-full rounded-xl border border-[#dfe7f5] bg-white px-3 text-sm text-[#30415e] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]">
                            </div>
                            <div>
                                <label for="kondisi_buku" class="mb-2 block text-sm font-semibold text-[#30415e]">Kondisi Buku</label>
                                <select id="kondisi_buku" name="kondisi_buku" required class="h-11 w-full rounded-xl border border-[#dfe7f5] bg-white px-3 text-sm text-[#30415e] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]">
                                    <option value="baik">Baik</option>
                                    <option value="rusak">Rusak</option>
                                    <option value="hilang">Hilang</option>
                                </select>
                            </div>
                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-[#4561e8] px-5 py-3 text-sm font-semibold text-white shadow-[0_8px_18px_rgba(69,97,232,0.24)] transition hover:bg-[#304bc3]">Simpan Pengembalian</button>
                        </form>
                    </div>
                @endif
            </section>
        </div>
    </main>
@endsection
