<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Laporan {{ ucfirst($type) }}</title><style>body{font-family:Arial,sans-serif}table{border-collapse:collapse;width:100%}th,td{border:1px solid #333;padding:6px;text-align:left}@media print{.print-actions{display:none}}</style></head>
<body>
    <div class="print-actions"><button type="button" onclick="window.print()">Cetak / Simpan PDF</button><a href="{{ route('laporan.index') }}">Kembali</a></div>
    <h1>Laporan {{ ucfirst($type) }} Perpustakaan</h1>
    @if ($type === 'buku')
        <table><thead><tr><th>Kode</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Rak</th><th>Stok</th></tr></thead><tbody>@foreach ($bukus as $buku)<tr><td>{{ $buku->kode_buku }}</td><td>{{ $buku->judul }}</td><td>{{ $buku->penulis }}</td><td>{{ $buku->kategori?->nama ?? '-' }}</td><td>{{ $buku->rak?->kode_rak ?? '-' }}</td><td>{{ $buku->stok }}</td></tr>@endforeach</tbody></table>
    @else
        <table><thead><tr><th>Anggota</th><th>Buku</th><th>Pinjam</th><th>Batas</th><th>Kembali</th><th>Status</th><th>Denda</th></tr></thead><tbody>@foreach ($peminjamans as $peminjaman)<tr><td>{{ $peminjaman->anggota->nama }}</td><td>{{ $peminjaman->buku->judul }}</td><td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td><td>{{ $peminjaman->batas_pengembalian->format('d-m-Y') }}</td><td>{{ $peminjaman->tanggal_dikembalikan?->format('d-m-Y') ?? '-' }}</td><td>{{ $peminjaman->status }}</td><td>Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</td></tr>@endforeach</tbody></table>
    @endif
</body>
</html>
