<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
</head>
<body>
    <h1>Daftar Buku</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('bukus.create') }}">Tambah Buku</a>

    <form action="{{ route('bukus.index') }}" method="GET">
        <label for="search">Cari buku</label>
        <input type="search" id="search" name="search" value="{{ $search }}" placeholder="Judul, penulis, atau kode buku">
        <button type="submit">Cari</button>
        @if ($search)
            <a href="{{ route('bukus.index') }}">Reset</a>
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
                <th>Aksi</th>
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
                    <td>
                        <a href="{{ route('bukus.show', $buku) }}">Detail</a>
                        <a href="{{ route('bukus.edit', $buku) }}">Edit</a>
                        <form action="{{ route('bukus.destroy', $buku) }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus buku ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $bukus->links() }}
</body>
</html>
