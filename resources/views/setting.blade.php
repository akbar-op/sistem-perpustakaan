@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-4 lg:px-5">
            <header class="flex items-start justify-between border-b border-[#e3e8f1] pb-4">
                <div>
                    <p class="text-xs text-[#8aa0c2]">Sistem Perpustakaan</p>
                    <p class="mt-1 text-base font-bold text-[#34445f]">Setting</p>
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
                <h1 class="text-3xl font-bold tracking-tight text-[#202d45]">Setting</h1>
                <p class="mt-1 text-sm text-[#7b8eaf]">Atur preferensi sistem dan konfigurasi</p>
            </section>

            <section class="mt-14 grid max-w-[800px] gap-14 xl:grid-cols-[1fr_240px]" aria-label="Pengaturan perpustakaan">
                <div>
                    <h2 class="text-base font-bold text-[#344563]">Pengaturan Perpustakaan</h2>
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="nama_perpustakaan" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Nama Perpustakaan</label>
                            <input id="nama_perpustakaan" type="text" value="Perpustakaan Sekolah" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                        <div>
                            <label for="alamat" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Alamat</label>
                            <input id="alamat" type="text" value="Perpustakaan Sekolah" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Email</label>
                            <input id="email" type="email" value="Perpustakaan Sekolah" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                        <div>
                            <label for="whatsapp" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">WhatsApp</label>
                            <input id="whatsapp" type="tel" value="+62 8123456789" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                    </div>

                    <h2 class="mt-14 text-base font-bold text-[#344563]">Peraturan Peminjaman</h2>
                    <div class="mt-4 grid gap-x-16 gap-y-4 sm:grid-cols-2">
                        <div>
                            <label for="maks_buku" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Maks. buku per anggota</label>
                            <input id="maks_buku" type="number" value="5" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                        <div>
                            <label for="durasi" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Waktu paling lama (hari)</label>
                            <input id="durasi" type="number" value="14" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                        <div>
                            <label for="denda" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Denda Perhari</label>
                            <input id="denda" type="text" value="Rp 7.000,00" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                        <div>
                            <label for="pembaruan" class="mb-1.5 block text-xs font-semibold text-[#657b9f]">Batas Pembaruan</label>
                            <input id="pembaruan" type="number" value="2" class="h-8 w-full rounded-none border border-[#9db7ff] bg-white px-2 text-base text-[#344563] outline-none focus:border-[#4561e8] focus:ring-1 focus:ring-[#cfe1ff]">
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-base font-bold text-[#344563]">Preferensi</h2>
                    <div class="mt-4 space-y-7">
                        <label class="flex cursor-pointer items-start justify-between gap-4">
                            <span>
                                <span class="block text-xs font-bold text-[#344563]">Notifikasi email</span>
                                <span class="mt-1 block text-xs font-semibold leading-4 text-[#657b9f]">Dapatkan peringatan untuk buku yang terlambat dikembalikan.</span>
                            </span>
                            <span class="relative mt-1 inline-flex shrink-0">
                                <input type="checkbox" checked class="peer sr-only">
                                <span class="h-6 w-10 rounded-full bg-[#d8dfe9] transition peer-checked:bg-[#4eb45b]"></span>
                                <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></span>
                            </span>
                        </label>
                        <label class="flex cursor-pointer items-start justify-between gap-4">
                            <span>
                                <span class="block text-xs font-bold text-[#344563]">Mode Gelap</span>
                                <span class="mt-1 block text-xs font-semibold text-[#657b9f]">Ganti ke tema gelap</span>
                            </span>
                            <span class="relative mt-1 inline-flex shrink-0">
                                <input id="dark-mode-toggle" type="checkbox" class="peer sr-only">
                                <span class="h-6 w-10 rounded-full bg-[#d8dfe9] transition peer-checked:bg-[#4eb45b]"></span>
                                <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-4"></span>
                            </span>
                        </label>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
