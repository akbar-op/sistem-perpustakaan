<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku</title>
</head>
<body>
    <header>
        <h1>Katalog Buku</h1>
        <p>Selamat datang, {{ auth()->user()->name }}.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </header>

    <form action="{{ route('katalog-buku.index') }}" method="GET">
        <label for="search">Cari buku</label>
        <input type="search" id="search" name="search" value="{{ $search }}" placeholder="Judul, penulis, atau kode buku">
        <button type="submit">Cari</button>
        @if ($search)
            <a href="{{ route('katalog-buku.index') }}">Reset</a>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Kategori</th>
                <th>Rak</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bukus as $buku)
                <tr>
                    <td>{{ $buku->kode_buku }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->penerbit }}</td>
                    <td>{{ $buku->kategori?->nama ?? '-' }}</td>
                    <td>{{ $buku->rak?->kode_rak ?? '-' }}</td>
                    <td>{{ $buku->stok }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $bukus->links() }}
</body>
</html>