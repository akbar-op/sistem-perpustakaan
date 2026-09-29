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
                    @include('layout.search')
                    <button type="button" aria-label="Notifikasi" class="relative grid h-10 w-10 place-items-center rounded-full border border-[#e1e7f1] bg-white text-[#8797b2] shadow-sm">
                        <img src="{{ asset('image/notification.png') }}" alt="" class="h-5 w-5 object-contain">
                        <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#4561e8] px-1 text-[10px] font-bold text-white">3</span>
                    </button>
                    @include('layout.theme-toggle')
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

                    <form action="{{ route('profil.update') }}" method="POST" class="mt-12 rounded-xl border border-[#e7ebf2] bg-white px-5 py-5 shadow-sm">
                        @csrf
                        @method('PUT')
                        <h2 class="text-xl font-bold text-[#344563]">Informasi Pribadi</h2>
                        @if (session('success'))
                            <p role="status" class="mt-3 rounded-lg bg-green-50 px-3 py-2 text-sm font-medium text-green-800">{{ session('success') }}</p>
                        @endif
                        @foreach (['name' => 'Nama lengkap', 'email' => 'Email'] as $field => $label)
                            <div class="mt-4">
                                <label for="{{ $field }}" class="mb-1.5 block text-sm font-semibold text-[#536b8a]">{{ $label }}</label>
                                <input id="{{ $field }}" name="{{ $field }}" type="{{ $field === 'email' ? 'email' : 'text' }}" value="{{ old($field, $user->$field) }}" required autocomplete="{{ $field === 'name' ? 'name' : 'email' }}" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2.5 text-sm text-[#25344d] focus:border-[#4561e8] focus:outline-none focus:ring-2 focus:ring-[#4561e8]/20">
                                @error($field)<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                            </div>
                        @endforeach
                        <div class="mt-6 border-t border-[#e7ebf2] pt-5">
                            <h3 class="text-sm font-bold text-[#344563]">Ubah kata sandi</h3>
                            <p class="mt-1 text-xs text-[#7b8eaf]">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                            <label for="password" class="mb-1.5 mt-4 block text-sm font-semibold text-[#536b8a]">Kata sandi baru</label>
                            <input id="password" name="password" type="password" autocomplete="new-password" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2.5 text-sm text-[#25344d] focus:border-[#4561e8] focus:outline-none focus:ring-2 focus:ring-[#4561e8]/20">
                            @error('password')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                            <label for="password_confirmation" class="mb-1.5 mt-4 block text-sm font-semibold text-[#536b8a]">Konfirmasi kata sandi</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="w-full rounded-lg border border-[#cbd5e1] px-3 py-2.5 text-sm text-[#25344d] focus:border-[#4561e8] focus:outline-none focus:ring-2 focus:ring-[#4561e8]/20">
                        </div>
                        <button type="submit" class="mt-6 rounded-lg bg-[#4561e8] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#304bc3]">Simpan perubahan</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
