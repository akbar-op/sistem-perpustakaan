<div class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
    @forelse ($bukus as $buku)
        @php
            $palettes = [
                ['from' => '#f2e8d7', 'to' => '#d9b07d', 'text' => '#4c3827'],
                ['from' => '#f1d7d7', 'to' => '#cf5d5d', 'text' => '#4f1d1d'],
                ['from' => '#dfe9ff', 'to' => '#8aa7ff', 'text' => '#1f2f5c'],
                ['from' => '#f0ebd7', 'to' => '#d8bc6f', 'text' => '#41371b'],
            ];
            $palette = $palettes[$loop->index % count($palettes)];
        @endphp

        <article class="rounded-[22px] border border-[#dfe7f5] bg-white p-4 shadow-[0_2px_8px_rgba(31,45,68,0.06)] transition hover:-translate-y-1 hover:shadow-[0_12px_25px_rgba(69,97,232,0.12)]">
            <div class="mx-auto mb-5 flex h-52 w-40 items-center justify-center rounded-[18px] border border-[#d9dfe9] bg-gradient-to-br shadow-inner" style="background: linear-gradient(135deg, {{ $palette['from'] }}, {{ $palette['to'] }}); color: {{ $palette['text'] }};">
                <div class="flex h-full w-full flex-col items-center justify-center px-3 text-center">
                    <div class="mb-2 h-10 w-10 rounded-full border border-current/50 bg-white/20 backdrop-blur-sm"></div>
                    <div class="text-[10px] font-bold uppercase tracking-[0.14em] leading-relaxed">
                        {{ \Illuminate\Support\Str::limit($buku->kategori?->nama ?? 'Umum', 12) }}
                    </div>
                    <div class="mt-2 text-lg font-black leading-tight tracking-tight">
                        {{ \Illuminate\Support\Str::limit($buku->judul, 18) }}
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#6f7f9d]">
                    {{ $buku->kategori?->nama ?? 'Umum' }}
                </p>
                <h3 class="min-h-[52px] text-xl font-bold leading-snug text-[#1f2d44]">
                    {{ \Illuminate\Support\Str::limit($buku->judul, 36) }}
                </h3>
                <p class="text-sm text-[#4d607d]">{{ $buku->penulis }}</p>
                <p class="line-clamp-4 text-sm leading-6 text-[#5d7396]">
                    {{ $buku->penerbit }} • {{ $buku->tahun_terbit ?? '2024' }}
                </p>
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $buku->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                    {{ $buku->status }}
                </span>

                <a href="{{ route($isStudent ? 'katalog-buku.show' : 'bukus.show', $buku) }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl border border-[#a9c0ff] bg-white px-4 py-2.5 text-sm font-semibold text-[#30415e] transition hover:bg-[#f3f7ff]">
                    Detail
                </a>
            </div>
        </article>
    @empty
        <div class="col-span-full rounded-2xl border border-dashed border-[#dfe7f5] bg-white px-6 py-14 text-center text-[#5d7396]">
            Belum ada data buku.
        </div>
    @endforelse
</div>