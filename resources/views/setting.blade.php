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
                    @include('layout.search')
                    <button type="button" aria-label="Notifikasi" class="relative grid h-10 w-10 place-items-center rounded-full border border-[#e1e7f1] bg-white text-[#8797b2] shadow-sm">
                        <img src="{{ asset('image/notification.png') }}" alt="" class="h-5 w-5 object-contain">
                        <span class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#4561e8] px-1 text-[10px] font-bold text-white">3</span>
                    </button>
                    @include('layout.theme-toggle')
                    <div class="grid h-10 w-10 place-items-center rounded-full bg-[#2d9bd2] text-sm font-bold text-white shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <section class="mt-8">
                <h1 class="text-3xl font-bold tracking-tight text-[#202d45]">Setting</h1>
                <p class="mt-1 text-sm text-[#7b8eaf]">Atur preferensi sistem dan konfigurasi</p>
            </section>

            <form action="{{ route('setting.update') }}" method="POST" class="mt-10 max-w-[900px]">
                @csrf
                @method('PUT')
                @if (session('success'))
                    <p role="status" class="mb-5 rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
                @endif
                <section class="grid gap-10 xl:grid-cols-[1fr_260px]" aria-label="Pengaturan perpustakaan">
                    <div>
                        <h2 class="text-base font-bold text-[#344563]">Pengaturan Perpustakaan</h2>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            @foreach ([
                                'library_name' => ['Nama perpustakaan', 'text'],
                                'address' => ['Alamat', 'text'],
                                'email' => ['Email', 'email'],
                                'whatsapp' => ['WhatsApp', 'tel'],
                            ] as $field => [$label, $type])
                                <div>
                                    <label for="{{ $field }}" class="mb-1.5 block text-sm font-semibold text-[#536b8a]">{{ $label }}</label>
                                    <input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field, $settings->$field) }}" required class="w-full rounded-lg border border-[#cbd5e1] bg-white px-3 py-2.5 text-sm text-[#344563] focus:border-[#4561e8] focus:outline-none focus:ring-2 focus:ring-[#4561e8]/20">
                                    @error($field)<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                        </div>

                        <h2 class="mt-10 text-base font-bold text-[#344563]">Peraturan Peminjaman</h2>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            @foreach ([
                                'max_books' => ['Maks. buku per anggota', 1, 50],
                                'loan_duration_days' => ['Durasi pinjam (hari)', 1, 365],
                                'fine_per_day' => ['Denda per hari (Rp)', 0, 1000000],
                                'renewal_limit' => ['Batas perpanjangan', 0, 10],
                            ] as $field => [$label, $minimum, $maximum])
                                <div>
                                    <label for="{{ $field }}" class="mb-1.5 block text-sm font-semibold text-[#536b8a]">{{ $label }}</label>
                                    <input id="{{ $field }}" name="{{ $field }}" type="number" min="{{ $minimum }}" max="{{ $maximum }}" value="{{ old($field, $settings->$field) }}" required class="w-full rounded-lg border border-[#cbd5e1] bg-white px-3 py-2.5 text-sm text-[#344563] focus:border-[#4561e8] focus:outline-none focus:ring-2 focus:ring-[#4561e8]/20">
                                    @error($field)<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h2 class="text-base font-bold text-[#344563]">Preferensi</h2>
                        <label class="mt-4 flex cursor-pointer items-start justify-between gap-4">
                            <span>
                                <span class="block text-sm font-semibold text-[#344563]">Notifikasi email</span>
                                <span class="mt-1 block text-xs leading-5 text-[#657b9f]">Peringatan untuk buku yang terlambat dikembalikan.</span>
                            </span>
                            <input type="checkbox" name="email_notifications" value="1" @checked(old('email_notifications', $settings->email_notifications)) class="mt-1 h-5 w-5 accent-[#4561e8]">
                        </label>
                    </div>
                </section>
                <button type="submit" class="mt-8 rounded-lg bg-[#4561e8] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#304bc3]">Simpan pengaturan</button>
            </form>
        </div>
    </main>
@endsection
