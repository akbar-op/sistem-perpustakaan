@php
$user = auth()->user();
$role = $user->role;
$isStudent = $user->isStudent();
$navigationItems = [
['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard', 'icon' => 'pixabay.png', 'roles' => ['admin', 'petugas', 'kepala_sekolah']],
['label' => 'List Buku', 'route' => $isStudent ? 'katalog-buku.index' : 'bukus.index', 'active' => $isStudent ? 'katalog-buku.*' : 'bukus.*', 'icon' => 'book.png', 'roles' => ['admin', 'petugas', 'siswa']],
['label' => 'Peminjaman Saya', 'route' => 'peminjamans.mine', 'active' => 'peminjamans.mine', 'icon' => 'arrow-up.png', 'roles' => ['siswa']],
['label' => 'Peminjaman', 'route' => 'peminjamans.create', 'active' => 'peminjamans.create', 'icon' => 'arrow-up.png', 'roles' => ['admin', 'petugas']],
['label' => 'Pengembalian', 'route' => 'peminjamans.index', 'query' => ['status' => 'dipinjam'], 'active' => 'peminjamans.index', 'activeStatus' => 'dipinjam', 'icon' => 'arrow-down.png', 'roles' => ['admin', 'petugas']],
['label' => 'Anggota', 'route' => 'anggotas.index', 'active' => 'anggotas.*', 'icon' => 'user.png', 'roles' => ['admin', 'petugas']],
['label' => 'Laporan', 'route' => 'laporan.index', 'active' => 'laporan.*', 'icon' => 'time.png', 'roles' => ['admin', 'petugas', 'kepala_sekolah']],
['label' => 'Profil', 'route' => 'profil', 'active' => 'profil*', 'icon' => 'profil.png', 'roles' => ['admin', 'petugas', 'siswa']],
['label' => 'Pengaturan', 'route' => 'setting', 'active' => 'setting', 'icon' => 'settings.png', 'roles' => ['admin', 'kepala_sekolah']],
];
@endphp

<aside class="flex w-full shrink-0 flex-col overflow-y-auto bg-[#4561e8] px-4 py-6 text-white lg:fixed lg:inset-y-0 lg:w-64 lg:px-3">
    <a href="{{ route($isStudent ? 'katalog-buku.index' : 'dashboard') }}" class="flex items-center gap-2 px-5 text-xl font-bold tracking-tight">
        <span class="grid h-9 w-9 place-items-center overflow-hidden rounded bg-white">
            <img src="{{ asset('image/ebook.png') }}" alt="" class="h-full w-full object-contain p-1">
        </span>
        PerpusKu
    </a>

    <div class="mt-10 border-t border-white/40 pt-2">
        <p class="px-1 text-[11px] font-semibold">Menu Utama</p>
        <nav class="mt-1 flex flex-wrap gap-1.5 lg:block" aria-label="Navigasi utama">
            @foreach ($navigationItems as $item)
            @if (in_array($role, $item['roles'], true))
            @php($active = request()->routeIs($item['active']) && (! isset($item['activeStatus']) || request('status', 'dipinjam') === $item['activeStatus']))
            <a href="{{ route($item['route'], $item['query'] ?? []) }}" @if ($active) aria-current="page" @endif class="flex items-center gap-4 rounded-full px-4 py-3 text-base font-semibold transition {{ $active ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }}">
                <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ $active ? 'bg-white' : 'bg-blue-500/20' }}">
                    <img src="{{ asset('image/'.$item['icon']) }}" alt="" class="h-full w-full object-contain p-1">
                </span>
                {{ $item['label'] }}
            </a>
            @endif
            @endforeach
        </nav>
    </div>

    <div class="mt-auto hidden border-t border-white/15 px-3 pt-5 lg:block">
        <p class="truncate text-sm font-semibold">{{ $user->name }}</p>
        <p class="mt-1 text-xs capitalize text-blue-100">{{ str_replace('_', ' ', $role) }}</p>
        <form class="mt-4" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full rounded-xl border border-white/20 px-4 py-2.5 text-left text-sm font-medium text-blue-50 transition hover:bg-white/10">Keluar</button>
        </form>
    </div>
</aside>