@if (! auth()->user()->isPrincipal())
    <form action="{{ route('bukus.index') }}" method="GET" class="hidden h-10 w-56 items-center rounded-full border border-[#8ea3ff] bg-white px-3 text-sm text-[#8ea0bf] shadow-sm sm:flex">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="7"></circle>
            <path d="m20 20-4-4"></path>
        </svg>
        <label for="header-search" class="sr-only">Cari buku</label>
        <input id="header-search" type="search" name="search" value="{{ request('search') }}" placeholder="Pencarian" class="w-full border-0 bg-transparent text-sm text-[#34445f] placeholder:text-[#8ea0bf] focus:outline-none focus:ring-0">
        <button type="submit" aria-label="Cari buku" class="sr-only">Cari</button>
    </form>
@endif
