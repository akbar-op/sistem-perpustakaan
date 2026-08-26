<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
</head>
<body>
    <h1>{{ $buku->judul }}</h1>

    <dl>
        <dt>Kode Buku</dt><dd>{{ $buku->kode_buku }}</dd>
        <dt>Penulis</dt><dd>{{ $buku->penulis }}</dd>
        <dt>Penerbit</dt><dd>{{ $buku->penerbit }}</dd>
        <dt>Tahun Terbit</dt><dd>{{ $buku->tahun_terbit ?? '-' }}</dd>
        <dt>ISBN</dt><dd>{{ $buku->isbn ?? '-' }}</dd>
        <dt>Kategori</dt><dd>{{ $buku->kategori?->nama ?? '-' }}</dd>
        <dt>Rak</dt><dd>{{ $buku->rak?->kode_rak ?? '-' }}</dd>
        <dt>Stok</dt><dd>{{ $buku->stok }}</dd>
    </dl>

    <a href="{{ route('bukus.edit', $buku) }}">Edit</a>
    <a href="{{ route('bukus.index') }}">Kembali</a>
</body>
</html>
