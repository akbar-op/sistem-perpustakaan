<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Laporan</title></head>
<body>
    <h1>Laporan Perpustakaan</h1>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    @if ($canViewBookReport)
        <section><h2>Laporan Buku</h2><a href="{{ route('laporan.print', 'buku') }}">Lihat / Cetak PDF</a> <a href="{{ route('laporan.excel', 'buku') }}">Export Excel</a></section>
    @endif
    <section><h2>Laporan Peminjaman</h2><a href="{{ route('laporan.print', 'peminjaman') }}">Lihat / Cetak PDF</a> <a href="{{ route('laporan.excel', 'peminjaman') }}">Export Excel</a></section>
</body>
</html>
