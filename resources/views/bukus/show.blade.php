@extends('layout.index')

@section('content')
<main class="w-full lg:ml-64">
    <div class="mx-auto max-w-[1440px] px-5 py-6 lg:px-8">
        <header class="flex items-center justify-end border-b border-[#e3e8f1] pb-4">
            <div class="flex items-center gap-3">
                @include('layout.search')
                <button type="button" aria-label="Notifikasi" class="relative grid h-11 w-11 place-items-center rounded-full border border-[#e1e7f1] bg-white text-lg text-[#8797b2] shadow-sm">
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
                <p class="text-sm font-semibold text-[#4561e8]">Katalog Buku</p>
                <h1 class="mt-1 text-4xl font-bold tracking-tight text-[#1f2d44]">Detail Buku</h1>
            </div>
            <a href="{{ route(auth()->user()->isStudent() ? 'katalog-buku.index' : 'bukus.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#dfe7f5] bg-white px-4 py-2.5 text-sm font-semibold text-[#30415e] shadow-sm transition hover:bg-[#f3f7ff]">
                <span aria-hidden="true">&larr;</span>
                Kembali ke daftar
            </a>
        </div>

        @if (session('error'))
        <div role="alert" class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-800">{{ session('error') }}</div>
        @endif

        <section class="mt-8 grid gap-6 lg:grid-cols-[280px_minmax(0,1fr)]" aria-labelledby="detail-buku-title">
            <div class="flex min-h-[360px] items-center justify-center rounded-[24px] border border-[#dfe7f5] bg-gradient-to-br from-[#dfe9ff] to-[#8aa7ff] p-8 shadow-[0_10px_25px_rgba(69,97,232,0.14)]">
                <div class="flex h-[290px] w-[205px] flex-col justify-between rounded-lg border border-white/70 bg-white/75 p-6 text-[#1f2f5c] shadow-[10px_12px_0_rgba(48,75,195,0.18)] backdrop-blur-sm">
                    <div class="text-[10px] font-bold uppercase tracking-[0.16em]">{{ $buku->kategori?->nama ?? 'Umum' }}</div>
                    <div>
                        <div class="mb-4 h-1 w-12 rounded-full bg-[#4561e8]"></div>
                        <p class="text-2xl font-black leading-tight">{{ $buku->judul }}</p>
                        <p class="mt-3 text-sm font-semibold">{{ $buku->penulis }}</p>
                    </div>
                    <div class="text-xs font-semibold">PerpusKu</div>
                </div>
            </div>

            <div class="rounded-[24px] border border-[#dfe7f5] bg-white p-6 shadow-[0_4px_14px_rgba(31,45,68,0.07)] sm:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-[#edf0f5] pb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[#6f7f9d]">Informasi Buku</p>
                        <h2 id="detail-buku-title" class="mt-2 text-3xl font-bold leading-tight text-[#1f2d44]">{{ $buku->judul }}</h2>
                        <p class="mt-2 text-sm text-[#5d7396]">Ditulis oleh {{ $buku->penulis }}</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $buku->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">{{ $buku->status }}</span>
                        <span class="rounded-full bg-[#eef3ff] px-3 py-1.5 text-xs font-bold text-[#4561e8]">Stok {{ $buku->stok }}</span>
                    </div>
                </div>

                <dl class="mt-6 grid gap-x-8 gap-y-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Kode Buku</dt>
                        <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $buku->kode_buku }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Penerbit</dt>
                        <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $buku->penerbit }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Tahun Terbit</dt>
                        <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $buku->tahun_terbit ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">ISBN</dt>
                        <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $buku->isbn ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Kategori</dt>
                        <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $buku->kategori?->nama ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-[0.1em] text-[#8b99b5]">Rak</dt>
                        <dd class="mt-1 text-base font-semibold text-[#30415e]">{{ $buku->rak?->kode_rak ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-wrap gap-3 border-t border-[#edf0f5] pt-6">
                    @if (auth()->user()->isStudent())
                    <form action="{{ route('katalog-buku.pinjam', $buku) }}" method="POST">
                        @csrf
                        <button type="submit" @disabled($buku->stok < 1) class="inline-flex items-center justify-center rounded-xl bg-[#4561e8] px-5 py-3 text-sm font-semibold text-white shadow-[0_8px_18px_rgba(69,97,232,0.24)] transition hover:bg-[#304bc3] disabled:cursor-not-allowed disabled:bg-gray-300 disabled:text-gray-600 disabled:shadow-none">
                            {{ $buku->stok > 0 ? 'Pinjam Buku' : 'Stok Habis' }}
                        </button>
                    </form>
                    @else
                    <a href="{{ route('bukus.edit', $buku) }}" class="inline-flex items-center justify-center rounded-xl bg-[#4561e8] px-5 py-3 text-sm font-semibold text-white shadow-[0_8px_18px_rgba(69,97,232,0.24)] transition hover:bg-[#304bc3]">Edit Buku</a>
                    @endif
                    <a href="{{ route(auth()->user()->isStudent() ? 'katalog-buku.index' : 'bukus.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#dfe7f5] bg-white px-5 py-3 text-sm font-semibold text-[#30415e] transition hover:bg-[#f3f7ff]">Kembali</a>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection