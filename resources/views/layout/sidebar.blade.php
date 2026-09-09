<aside class="flex w-full shrink-0 flex-col bg-[#4561e8] px-4 py-6 text-white lg:fixed lg:inset-y-0 lg:w-64 lg:px-3">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-5 text-xl font-bold tracking-tight">
                <span class="grid h-9 w-9 place-items-center overflow-hidden rounded bg-white">
                    <img
                        src="{{ asset('image/ebook.png') }}"
                        alt="Logo PerpusKu"
                        class="h-full w-full object-contain p-1">
                </span>PerpusKu</a>
            <div class="mt-10 border-t border-white/40 pt-2"><p class="px-1 text-[11px] font-semibold">Menu Utama</p>
            <nav class="mt-1 flex flex-wrap gap-1.5 lg:block" aria-label="Navigasi utama">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 rounded-full px-4 py-2 text-lg font-bold {{ request()->routeIs('dashboard') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }}">
                    <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('dashboard') ? 'bg-white' : 'bg-blue-500/20' }}">
                        <img
                            src="{{ asset('image/pixabay.png') }}"
                            alt="Logo Dashboard"
                            class="h-full w-full object-contain p-1">
                    </span>
                    Dashboard
                </a>
                @if (! auth()->user()->isPrincipal())
                    <a href="{{ route('bukus.index') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('bukus.index') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                        <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('bukus.index') ? 'bg-white' : 'bg-blue-500/20' }}">
                            <img
                                src="{{ asset('image/book.png') }}"
                                alt="Logo Buku"
                                class="h-full w-full object-contain p-1">
                        </span>
                        List Buku
                    </a>
                @endif
                @if (! auth()->user()->isPrincipal())
                    <a href="{{ route('peminjamans.create') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('peminjamans.create') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                        <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('peminjamans.create') ? 'bg-white' : 'bg-blue-500/20' }}">
                            <img
                                src="{{ asset('image/arrow-up.png') }}"
                                alt="Logo Peminjaman"
                                class="h-full w-full object-contain p-1">
                        </span>
                        Peminjaman Buku
                    </a>
                    <a href="{{ route('peminjamans.index') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('peminjamans.index') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                        <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('peminjamans.index') ? 'bg-white' : 'bg-blue-500/20' }}">
                            <img
                                src="{{ asset('image/arrow-down.png') }}"
                                alt="Logo Pengembalian"
                                class="h-full w-full object-contain p-1">
                        </span>
                        Pengembalian Buku
                    </a>
                    <a href="{{ route('anggotas.index') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('anggotas.index') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                        <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('anggotas.index') ? 'bg-white' : 'bg-blue-500/20' }}">
                            <img
                                src="{{ asset('image/user.png') }}"
                                alt="Logo Anggota"
                                class="h-full w-full object-contain p-1">
                </span>Anggota</a>
                @endif
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('laporan.index') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                    <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('laporan.index') ? 'bg-white' : 'bg-blue-500/20' }}">
                        <img
                            src="{{ asset('image/time.png') }}"
                            alt="Logo Laporan"
                            class="h-full w-full object-contain p-1">
                    </span>
                    Laporan
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('profil') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                    <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('profil') ? 'bg-white' : 'bg-blue-500/20' }}">
                        <img
                            src="{{ asset('image/profil.png') }}"
                            alt="Logo Profil"
                            class="h-full w-full object-contain p-1">
                </span>Profil</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('setting') }}" class="flex items-center gap-4 rounded-full px-4 py-3 text-lg font-semibold {{ request()->routeIs('setting') ? 'bg-white text-[#4561e8]' : 'text-white hover:bg-white/10' }} transition">
                        <span class="grid h-9 w-9 place-items-center overflow-hidden rounded {{ request()->routeIs('setting') ? 'bg-white' : 'bg-blue-500/20' }}">
                            <img
                                src="{{ asset('image/settings.png') }}"
                                alt="Logo Settings"
                                class="h-full w-full object-contain p-1">
                        </span>
                        Setting
                    </a>
                @endif
            </nav></div>
            <div class="mt-auto hidden border-t border-white/15 px-3 pt-5 lg:block"><p class="truncate text-sm font-semibold">{{ auth()->user()->name }}</p><p class="mt-1 text-xs capitalize text-blue-100">{{ str_replace('_', ' ', auth()->user()->role) }}</p><form class="mt-4" action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="w-full rounded-xl border border-white/20 px-4 py-2.5 text-left text-sm font-medium text-blue-50 transition hover:bg-white/10">Keluar</button></form></div>
        </aside>