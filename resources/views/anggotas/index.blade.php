@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-4 lg:px-5">
            <header class="flex items-start justify-between border-b border-[#e3e8f1] pb-4">
                <div class="hidden sm:block">
                    <p class="text-xs text-[#8aa0c2]">Sistem Perpustakaan</p>
                    <p class="mt-1 text-base font-bold text-[#34445f]">Anggota Perpustakaan</p>
                </div>
                <div class="ml-auto flex items-center gap-3">
                    <form action="{{ route('anggotas.index') }}" method="GET" class="flex h-10 w-56 items-center rounded-full border border-[#4561e8] bg-white px-3 text-sm text-[#8ea0bf] sm:w-60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 shrink-0 text-[#8ea0bf]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-4-4"></path>
                        </svg>
                        <input type="search" name="search" value="{{ $search }}" placeholder="Pencarian" class="w-full border-0 bg-transparent text-sm text-[#34445f] placeholder:text-[#8ea0bf] focus:outline-none focus:ring-0">
                    </form>
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
                <h1 class="text-4xl font-bold tracking-tight text-[#202d45]">Anggota</h1>
                <p class="mt-1 text-sm text-[#61789d]">{{ $totalAnggota }} Anggota terdaftar</p>
            </section>

            <section class="mt-4 grid max-w-[570px] grid-cols-1 gap-4 sm:grid-cols-3" aria-label="Statistik anggota">
                <div class="rounded-md bg-[#4561e8] px-3 py-2 text-white">
                    <p class="text-[10px]">Total</p>
                    <p class="mt-1 text-xl font-bold leading-none">{{ $totalAnggota }}</p>
                </div>
                <div class="rounded-md bg-[#4561e8] px-3 py-2 text-white">
                    <p class="text-[10px]">Aktif</p>
                    <p class="mt-1 text-xl font-bold leading-none">{{ $anggotaAktif }}</p>
                </div>
                <div class="rounded-md bg-[#4561e8] px-3 py-2 text-white">
                    <p class="text-[10px]">Tidak aktif</p>
                    <p class="mt-1 text-xl font-bold leading-none">{{ $anggotaTidakAktif }}</p>
                </div>
            </section>

            @if (session('success'))
                <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
            @endif

            <section class="mt-12 max-w-[980px]">
                <form action="{{ route('anggotas.index') }}" method="GET" class="flex h-10 items-center rounded-md border border-[#e0e7f2] bg-white px-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"></circle>
                        <path d="m20 20-4-4"></path>
                    </svg>
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari anggota..." class="w-full border-0 bg-transparent text-xs text-[#34445f] placeholder:text-[#60779c] focus:outline-none focus:ring-0">
                </form>

                <div class="mt-6 overflow-x-auto">
                    <table class="w-full min-w-[900px] table-fixed text-left text-sm text-[#60779c]">
                        <colgroup>
                            <col class="w-[6%]">
                            <col class="w-[15%]">
                            <col class="w-[14%]">
                            <col class="w-[16%]">
                            <col class="w-[14%]">
                            <col class="w-[15%]">
                            <col class="w-[10%]">
                            <col class="w-[10%]">
                        </colgroup>
                        <thead>
                            <tr class="text-xs font-semibold">
                                <th class="px-2 py-2">#</th>
                                <th class="px-2 py-2">Anggota</th>
                                <th class="px-2 py-2">NISN/NIP</th>
                                <th class="px-2 py-2">Email</th>
                                <th class="px-2 py-2">No. HP</th>
                                <th class="px-2 py-2">Tgl. Daftar</th>
                                <th class="px-2 py-2">Status</th>
                                <th class="px-2 py-2">Pinjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($anggotas as $anggota)
                                <tr class="align-top text-[13px] font-semibold">
                                    <td class="px-2 py-2">{{ $anggotas->firstItem() + $loop->index }}</td>
                                    <td class="px-2 py-2 text-[#536b8f]">{{ $anggota->nama }}</td>
                                    <td class="break-words px-2 py-2">{{ $anggota->nis_nip ?? '-' }}</td>
                                    <td class="break-words px-2 py-2">{{ $anggota->email ?? '-' }}</td>
                                    <td class="break-words px-2 py-2">{{ $anggota->no_telepon ?? '-' }}</td>
                                    <td class="px-2 py-2">{{ $anggota->created_at?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="px-2 py-2">{{ $anggota->aktif ? 'Aktif' : 'Tidak aktif' }}</td>
                                    <td class="px-2 py-2">{{ $anggota->pinjaman_aktif_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-2 py-12 text-center text-sm font-normal">Belum ada data anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $anggotas->links() }}</div>
            </section>
        </div>
    </main>
@endsection
