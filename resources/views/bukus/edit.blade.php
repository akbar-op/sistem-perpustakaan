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
                <h1 class="mt-1 text-3xl font-bold tracking-tight text-[#1f2d44] sm:text-4xl">Edit Buku</h1>
                <p class="mt-1 text-sm text-[#5d7396]">Perbarui informasi buku di koleksi perpustakaan.</p>
            </div>
            <a href="{{ route('bukus.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#dfe7f5] bg-white px-4 py-2.5 text-sm font-semibold text-[#30415e] shadow-sm transition hover:bg-[#f3f7ff]">
                <span aria-hidden="true">&larr;</span>
                Kembali ke daftar
            </a>
        </div>

        @if ($errors->any())
        <div role="alert" class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
            <p class="font-semibold">Perubahan belum dapat disimpan. Periksa kembali isian berikut:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('bukus.update', $buku) }}" method="POST" class="mt-6 overflow-hidden rounded-2xl border border-[#dfe7f5] bg-white shadow-[0_4px_14px_rgba(31,45,68,0.06)]">
            @csrf
            @method('PUT')

            <div class="border-b border-[#edf0f5] px-5 py-5 sm:px-8">
                <h2 class="text-lg font-bold text-[#1f2d44]">Informasi Buku</h2>
                <p class="mt-1 text-sm text-[#71809a]">Periksa data saat ini sebelum menyimpan perubahan.</p>
            </div>

            <div class="grid gap-x-6 gap-y-5 px-5 py-6 sm:grid-cols-2 sm:px-8">
                <div>
                    <label for="kode_buku" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Kode Buku <span class="text-red-600">*</span></label>
                    <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku) }}" required aria-invalid="{{ $errors->has('kode_buku') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('kode_buku') border-red-400 @enderror">
                    @error('kode_buku')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="judul" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Judul Buku <span class="text-red-600">*</span></label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" required aria-invalid="{{ $errors->has('judul') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('judul') border-red-400 @enderror">
                    @error('judul')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="penulis" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Penulis <span class="text-red-600">*</span></label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required aria-invalid="{{ $errors->has('penulis') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('penulis') border-red-400 @enderror">
                    @error('penulis')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="penerbit" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Penerbit <span class="text-red-600">*</span></label>
                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required aria-invalid="{{ $errors->has('penerbit') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('penerbit') border-red-400 @enderror">
                    @error('penerbit')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tahun_terbit" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Tahun Terbit</label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1" max="{{ now()->year }}" aria-invalid="{{ $errors->has('tahun_terbit') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('tahun_terbit') border-red-400 @enderror">
                    @error('tahun_terbit')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="isbn" class="mb-1.5 block text-sm font-semibold text-[#30415e]">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn) }}" aria-invalid="{{ $errors->has('isbn') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('isbn') border-red-400 @enderror">
                    @error('isbn')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kategori_id" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Kategori</label>
                    <select id="kategori_id" name="kategori_id" aria-invalid="{{ $errors->has('kategori_id') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('kategori_id') border-red-400 @enderror">
                        <option value="">Pilih kategori</option>
                        @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected(old('kategori_id', $buku->kategori_id) == $kategori->id)>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="rak_id" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Rak</label>
                    <select id="rak_id" name="rak_id" aria-invalid="{{ $errors->has('rak_id') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('rak_id') border-red-400 @enderror">
                        <option value="">Pilih rak</option>
                        @foreach ($raks as $rak)
                        <option value="{{ $rak->id }}" @selected(old('rak_id', $buku->rak_id) == $rak->id)>{{ $rak->kode_rak }} - {{ $rak->nama }}</option>
                        @endforeach
                    </select>
                    @error('rak_id')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2 sm:max-w-xs">
                    <label for="stok" class="mb-1.5 block text-sm font-semibold text-[#30415e]">Stok <span class="text-red-600">*</span></label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" min="0" required aria-invalid="{{ $errors->has('stok') ? 'true' : 'false' }}" class="w-full rounded-lg border border-[#dfe7f5] bg-white px-3.5 py-2.5 text-sm text-[#253858] outline-none transition focus:border-[#7890f2] focus:ring-2 focus:ring-[#4561e8]/15 @error('stok') border-red-400 @enderror">
                    @error('stok')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-[#edf0f5] bg-[#fbfcfe] px-5 py-4 sm:flex-row sm:justify-end sm:px-8">
                <a href="{{ route('bukus.index') }}" class="inline-flex items-center justify-center rounded-lg border border-[#dfe7f5] bg-white px-5 py-2.5 text-sm font-semibold text-[#30415e] transition hover:bg-[#f3f7ff]">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-[#4561e8] px-5 py-2.5 text-sm font-semibold text-white shadow-[0_6px_14px_rgba(69,97,232,0.22)] transition hover:bg-[#304bc3]">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</main>
@endsection