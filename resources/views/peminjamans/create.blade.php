@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-6 lg:px-8">
            <header class="flex items-center justify-end border-b border-[#e3e8f1] pb-4">
                <div class="flex items-center gap-3">
                    <div class="hidden h-10 w-56 items-center rounded-full border border-[#dfe7f5] bg-white px-3 text-sm text-[#8ea0bf] shadow-sm sm:flex">
                        <span class="mr-2 text-lg">⌕</span>
                        <span>Pencarian</span>
                    </div>
                    <button type="button" aria-label="Notifikasi" class="relative grid h-10 w-10 place-items-center rounded-full border border-[#e1e7f1] bg-white text-lg text-[#8797b2] shadow-sm">
                        <img src="{{ asset('image/notification.png') }}" alt="Notifikasi" class="h-5 w-5 object-contain">
                        <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#4561e8] px-1 text-[10px] font-bold text-white">3</span>
                    </button>
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-[#2d9bd2] text-sm font-bold text-white shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="mt-8 flex justify-center">
                <div class="w-full max-w-[760px]">
                    <h2 class="text-4xl font-bold tracking-tight text-[#1f2d44]">Pinjam Buku</h2>
                    <p class="mt-1 text-sm text-[#5d7396]">Buat transaksi peminjaman baru</p>

                    <div class="mt-8">
                        <h3 class="mb-4 flex items-center gap-2 text-[22px] font-semibold text-[#273a54]">
                            <span class="text-xl">↑</span>
                            <span>Detail Pinjam Buku</span>
                        </h3>

                        @if ($errors->any())
                            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if ($bukus->isEmpty())
                            <div class="mb-4 rounded-xl border border-dashed border-[#dfe7f5] bg-[#f8faff] p-3 text-sm text-[#5d7396]">
                                Tidak ada buku yang tersedia.
                            </div>
                        @endif

                        <form action="{{ route('peminjamans.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label for="nis_nip" class="mb-2 block text-base font-medium text-[#2b3d5d]">Anggota</label>
                                    <select id="nis_nip" name="nis_nip" required class="w-full rounded-xl border border-[#98b2ff] bg-white px-4 py-3 text-base text-[#2a3b53] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]">
                                        <option value="">pilih anggota...</option>
                                        @foreach ($anggotas as $anggota)
                                            <option value="{{ $anggota->nis_nip }}" {{ old('nis_nip') == $anggota->nis_nip ? 'selected' : '' }}>
                                                {{ $anggota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="buku_id" class="mb-2 block text-base font-medium text-[#2b3d5d]">Buku</label>
                                    <select id="buku_id" name="buku_id" required class="w-full rounded-xl border border-[#98b2ff] bg-white px-4 py-3 text-base text-[#2a3b53] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]">
                                        <option value="">pilih buku...</option>
                                        @foreach ($bukus as $buku)
                                            <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                                                {{ $buku->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <label for="tanggal_pinjam" class="mb-2 block text-base font-medium text-[#2b3d5d]">Tanggal Pinjam</label>
                                    <div class="relative">
                                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', today()->toDateString()) }}" required class="w-full rounded-xl border border-[#98b2ff] bg-white px-4 py-3 pr-10 text-base text-[#2a3b53] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]">
                                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-[#4561e8]">📅</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="batas_pengembalian" class="mb-2 block text-base font-medium text-[#2b3d5d]">Tanggal Batas</label>
                                    <div class="relative">
                                        <input type="date" id="batas_pengembalian" name="batas_pengembalian" value="{{ old('batas_pengembalian', today()->addDays(7)->toDateString()) }}" required class="w-full rounded-xl border border-[#98b2ff] bg-white px-4 py-3 pr-10 text-base text-[#2a3b53] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]">
                                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-[#4561e8]">📅</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="catatan" class="mb-2 block text-base font-medium text-[#2b3d5d]">Catatan (Opsional)</label>
                                <textarea id="catatan" name="catatan" rows="4" placeholder="Tulis catatan..." class="w-full rounded-xl border border-[#98b2ff] bg-white px-4 py-3 text-base text-[#2a3b53] placeholder:text-[#8b99b5] outline-none transition focus:border-[#4561e8] focus:ring-2 focus:ring-[#cfe1ff]"></textarea>
                            </div>

                            <div class="flex justify-center gap-4 pt-2">
                                <button type="submit" @disabled($bukus->isEmpty() || $anggotas->isEmpty()) class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#4561e8] bg-[#4561e8] px-8 py-3 text-base font-semibold text-white shadow-[0_8px_18px_rgba(69,97,232,0.22)] transition hover:bg-[#304bc3] disabled:cursor-not-allowed disabled:opacity-60">
                                    <span>✓</span>
                                    Konfirmasi Pinjam
                                </button>
                                <a href="{{ route('peminjamans.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#a6b9f7] bg-white px-8 py-3 text-base font-semibold text-[#30415e] transition hover:bg-[#f4f7ff]">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
