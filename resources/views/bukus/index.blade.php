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

            <div class="mt-8 flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-4xl font-bold tracking-tight text-[#1f2d44]">List Buku</h2>
                    <p class="mt-1 text-sm text-[#5d7396]">Buku yang sering di baca</p>
                </div>

                <a href="{{ route('bukus.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#4561e8] px-5 py-3 text-base font-semibold text-white shadow-[0_8px_18px_rgba(69,97,232,0.28)] transition hover:bg-[#304bc3]">
                    + Tambah
                </a>
            </div>

            <form action="{{ route('bukus.index') }}" method="GET" class="mt-8 rounded-[20px] border border-[#a9c0ff] bg-white px-4 py-3 shadow-[0_2px_6px_rgba(69,97,232,0.08)]">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-full bg-[#f3f7ff] text-[#4561e8]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="6"></circle>
                            <path d="m16 16 4.5 4.5"></path>
                        </svg>
                    </span>

                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari dengan Judul, Pengarang, Tipe buku"
                        class="flex-1 border-0 bg-transparent text-base text-[#2a3b53] placeholder:text-[#8b99b5] focus:outline-none focus:ring-0"
                    >

                    <label class="sr-only" for="kategori_id">Filter kategori</label>
                    <select id="kategori_id" name="kategori_id" class="max-w-48 rounded-full border border-[#dfe7f5] bg-[#f7f9fc] px-4 py-2 text-sm font-medium text-[#30415e] outline-none focus:ring-2 focus:ring-[#a9c0ff]">
                        <option value="">Semua kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected($kategoriId === $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-full bg-[#4561e8] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#304bc3]">Cari</button>
                </div>
            </form>

            @include('bukus.partials.card-grid', ['isStudent' => false])

            <div class="mt-8 flex justify-center">
                {{ $bukus->links() }}
            </div>
        </div>
    </main>
@endsection