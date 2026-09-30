<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | PerpusKu</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-[#f4f7fc] text-[#14213d]">
    <main class="grid min-h-screen lg:grid-cols-[minmax(0,1fr)_minmax(420px,0.92fr)]">
        <section class="relative flex min-h-[420px] flex-col overflow-hidden bg-[#4161e8] px-7 py-8 text-white sm:px-12 lg:min-h-screen lg:px-16 lg:py-12">
            <div class="relative z-10 flex items-center gap-3 text-xl font-bold tracking-tight"><span class="grid h-9 w-9 place-items-center overflow-hidden rounded bg-white">
                    <img
                        src="{{ asset('image/ebook.png') }}"
                        alt="Logo PerpusKu"
                        class="h-full w-full object-contain p-1">
                </span>PerpusKu</div>
            <div class="relative z-10 my-auto max-w-lg py-16">
                <p class="mb-5 inline-flex rounded-full bg-white/12 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-blue-100">Administrator Portal</p>
                <h1 class="max-w-md text-4xl font-bold leading-tight tracking-tight sm:text-5xl">Kelola perpustakaan dengan percaya diri.</h1>
                <p class="mt-6 max-w-md text-base leading-7 text-blue-100">Pantau koleksi buku, anggota, peminjaman, dan pengembalian dari satu ruang kerja yang sederhana.</p>
                <div class="mt-10 grid max-w-md grid-cols-2 gap-3">
                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-2xl font-bold">24/7</p>
                        <p class="mt-1 text-xs text-blue-100">Akses data</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4">
                        <p class="text-2xl font-bold">Aman</p>
                        <p class="mt-1 text-xs text-blue-100">Untuk sekolah</p>
                    </div>
                </div>
            </div>
            <p class="relative z-10 text-xs text-blue-200">LibraMS &middot; Sistem manajemen perpustakaan</p>
            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full border-[32px] border-white/8"></div>
            <div class="pointer-events-none absolute -bottom-40 -left-24 h-80 w-80 rounded-full border-[40px] border-white/8"></div>
        </section>

        <section class="flex items-center justify-center px-6 py-12 sm:px-12 lg:px-16">
            <div class="w-full max-w-md">
                <div class="mb-8 lg:hidden"><span class="grid h-10 w-10 place-items-center rounded-xl bg-[#4161e8] text-sm font-black text-white">LM</span></div>
                <p class="text-sm font-semibold text-[#4161e8]">Selamat datang kembali</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-[#14213d]">Masuk ke akun Anda</h2>
                <p class="mt-3 text-sm leading-6 text-[#71809d]">Gunakan email dan password yang terdaftar untuk melanjutkan.</p>

                @if ($errors->any())
                <div class="mt-6 rounded-xl border border-[#f4c5bc] bg-[#fff5f2] px-4 py-3 text-sm text-[#b6503f]" role="alert">{{ $errors->first() }}</div>
                @endif

                <form class="mt-8 space-y-5" action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#263653]">Alamat email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="nama@sekolah.sch.id" class="w-full rounded-xl border border-[#dce3f0] bg-white px-4 py-3.5 text-sm text-[#14213d] outline-none transition placeholder:text-[#a8b2c3] focus:border-[#4161e8] focus:ring-4 focus:ring-[#4161e8]/10">
                    </div>
                    <div>
                        <div class="mb-2 flex items-center justify-between"><label for="password" class="block text-sm font-semibold text-[#263653]">Password</label><span class="text-xs text-[#9aa6ba]">Akses terlindungi</span></div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Masukkan password Anda" class="w-full rounded-xl border border-[#dce3f0] bg-white px-4 py-3.5 text-sm text-[#14213d] outline-none transition placeholder:text-[#a8b2c3] focus:border-[#4161e8] focus:ring-4 focus:ring-[#4161e8]/10">
                    </div>
                    <label class="flex items-center gap-3 text-sm text-[#71809d]"><input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#cbd5e5] text-[#4161e8] focus:ring-[#4161e8]"> Ingat saya di perangkat ini</label>
                    <button type="submit" class="w-full rounded-xl bg-[#4161e8] px-5 py-3.5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(65,97,232,0.22)] transition hover:bg-[#304bc3] focus:outline-none focus:ring-4 focus:ring-[#4161e8]/20">Masuk ke dashboard</button>
                </form>
                <p class="mt-8 text-center text-xs text-[#9aa6ba]">Hubungi administrator sekolah jika Anda mengalami kendala masuk.</p>
            </div>
        </section>
    </main>
</body>

</html>