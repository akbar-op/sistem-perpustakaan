@extends('layout.index')

@section('content')
    <main class="w-full lg:ml-64">
        <div class="mx-auto max-w-[1440px] px-5 py-6 lg:px-8">
            <header class="border-b border-[#e3e8f1] pb-5">
                <p class="text-xs text-[#8aa0c2]">Perpustakaan Sekolah</p>
                <h1 class="mt-1 text-2xl font-bold text-[#202d45]">Peminjaman Saya</h1>
                <p class="mt-1 text-sm text-[#5d7396]">Buku yang sedang dipinjam dan riwayat pengembalian.</p>
            </header>

            @if (session('success'))
                <div role="status" class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div role="alert" class="mt-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-800">{{ session('error') }}</div>
            @endif

            <nav class="mt-6 flex gap-2 border-b border-[#e3e8f1]" aria-label="Filter peminjaman">
                <a href="{{ route('peminjamans.mine', ['status' => 'dipinjam']) }}" @if ($status === 'dipinjam') aria-current="page" @endif class="border-b-2 px-4 py-3 text-sm font-semibold {{ $status === 'dipinjam' ? 'border-[#4561e8] text-[#304bc3]' : 'border-transparent text-[#657b9f] hover:text-[#304bc3]' }}">Sedang dipinjam</a>
                <a href="{{ route('peminjamans.mine', ['status' => 'dikembalikan']) }}" @if ($status === 'dikembalikan') aria-current="page" @endif class="border-b-2 px-4 py-3 text-sm font-semibold {{ $status === 'dikembalikan' ? 'border-[#4561e8] text-[#304bc3]' : 'border-transparent text-[#657b9f] hover:text-[#304bc3]' }}">Riwayat</a>
            </nav>

            <div class="mt-5 overflow-x-auto rounded-xl border border-[#e3e8f1] bg-white">
                <table class="w-full min-w-[680px] text-left text-sm">
                    <thead class="bg-[#f7f9fc] text-xs uppercase text-[#657b9f]">
                        <tr>
                            <th scope="col" class="px-5 py-3">Judul buku</th>
                            <th scope="col" class="px-5 py-3">Tanggal pinjam</th>
                            <th scope="col" class="px-5 py-3">Batas kembali</th>
                            @if ($status === 'dikembalikan')
                                <th scope="col" class="px-5 py-3">Tanggal kembali</th>
                            @endif
                            <th scope="col" class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#edf0f5] text-[#344563]">
                        @forelse ($peminjamans as $peminjaman)
                            <tr>
                                <td class="px-5 py-4 font-semibold">{{ $peminjaman->buku?->judul ?? 'Buku tidak ditemukan' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $peminjaman->batas_pengembalian?->format('d-m-Y') ?? '-' }}</td>
                                @if ($status === 'dikembalikan')
                                    <td class="whitespace-nowrap px-5 py-4">{{ $peminjaman->tanggal_dikembalikan?->format('d-m-Y') ?? '-' }}</td>
                                @endif
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $status === 'dipinjam' ? 'bg-amber-50 text-amber-800' : 'bg-green-50 text-green-800' }}">{{ $status === 'dipinjam' ? 'Sedang dipinjam' : 'Dikembalikan' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $status === 'dikembalikan' ? 5 : 4 }}" class="px-5 py-12 text-center text-[#7b8eaf]">Tidak ada data peminjaman pada bagian ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $peminjamans->links() }}</div>
        </div>
    </main>
@endsection