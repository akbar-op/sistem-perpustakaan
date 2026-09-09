@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-4 lg:px-5">
            <header class="flex items-start justify-between border-b border-[#e3e8f1] pb-4">
                <div>
                    <p class="text-xs text-[#8aa0c2]">Sistem Perpustakaan</p>
                    <p class="mt-1 text-base font-bold text-[#34445f]">Profile</p>
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
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <section class="mx-auto mt-14 max-w-[750px] xl:mx-0 xl:ml-12">
                <div class="grid items-start gap-12 xl:grid-cols-[220px_minmax(0,1fr)]">
                    <div class="text-center">
                        <h1 class="text-3xl font-bold tracking-tight text-[#202d45]">Profile Saya</h1>
                        <p class="mt-1 text-sm text-[#5d7396]">Manage your personal information</p>

                        <div class="relative mx-auto mt-4 h-36 w-36 overflow-visible rounded-full bg-gradient-to-br from-[#08bfe9] via-[#1b9bd1] to-[#4656bd] p-2">
                            <div class="grid h-full w-full place-items-center overflow-hidden rounded-full bg-white">
                                <img src="{{ asset('image/profile.png') }}" alt="Foto profil {{ $user->name }}" class="h-full w-full object-contain p-2">
                            </div>
                            <button type="button" aria-label="Ubah foto profil" class="absolute bottom-1 right-[-2px] grid h-9 w-9 place-items-center rounded-full border-4 border-white bg-[#269cf0] text-white shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M14.5 4h-5L8 7H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3z"></path>
                                    <circle cx="12" cy="13" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <h2 class="mt-3 text-xl font-bold text-[#202d45]">{{ $user->name }}</h2>
                        <p class="text-xs text-[#8aa0c2]">Sistem Administrasi</p>
                        <p class="mt-8 text-xl font-bold text-[#202d45]">{{ $totalTransaksi }}</p>
                        <p class="text-xs text-[#8aa0c2]">Total Transaksi</p>
                    </div>

                    <div class="mt-12 rounded-2xl border border-[#e7ebf2] bg-white px-5 py-4 shadow-[0_2px_3px_rgba(31,45,68,0.22)]">
                        <h2 class="text-xl font-bold text-[#344563]">Informasi Pribadi</h2>
                        <dl class="mt-3 grid grid-cols-1 gap-x-10 gap-y-5 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs text-[#8aa0c2]">Nama Lengkap</dt>
                                <dd class="mt-1 text-base font-bold text-[#25344d]">{{ $user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-[#8aa0c2]">Email</dt>
                                <dd class="mt-1 break-words text-base font-bold text-[#25344d]">{{ $user->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-[#8aa0c2]">Nomor Handphone</dt>
                                <dd class="mt-1 text-base font-bold text-[#25344d]">-</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-[#8aa0c2]">Alamat</dt>
                                <dd class="mt-1 text-base font-bold text-[#25344d]">-</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-[#8aa0c2]">Employee</dt>
                                <dd class="mt-1 text-base font-bold capitalize text-[#25344d]">{{ str_replace('_', ' ', $user->role) }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-[#8aa0c2]">Nama Lengkap</dt>
                                <dd class="mt-1 text-base font-bold text-[#25344d]">{{ $user->name }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
