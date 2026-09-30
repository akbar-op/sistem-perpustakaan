<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Buku</title>
</head>

<body>
    <h1>Kategori Buku</h1>@if(session('success'))<p>{{ session('success') }}</p>@endif<a href="{{ route('kategoris.create') }}">Tambah Kategori</a> <a href="{{ route('dashboard') }}">Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Jumlah Buku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>@forelse($kategoris as $kategori)<tr>
                <td>{{ $kategori->nama }}</td>
                <td>{{ $kategori->deskripsi ?? '-' }}</td>
                <td>{{ $kategori->bukus_count }}</td>
                <td><a href="{{ route('kategoris.edit', $kategori) }}">Edit</a>
                    <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button type="submit">Hapus</button></form>
                </td>
            </tr>@empty<tr>
                <td colspan="4">Belum ada kategori.</td>
            </tr>@endforelse</tbody>
    </table>
</body>

</html>