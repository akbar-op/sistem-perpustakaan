<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Peminjaman</title></head>
<body>
    <h1>Transaksi Peminjaman</h1>
    @if (session('success')) <p>{{ session('success') }}</p> @endif
    <a href="{{ route('peminjamans.create') }}">Catat Peminjaman</a>
    <a href="{{ route('bukus.index') }}">Buku</a>
    <a href="{{ route('anggotas.index') }}">Anggota</a>
    <table>
        <thead><tr><th>Anggota</th><th>Buku</th><th>Tanggal Pinjam</th><th>Batas Kembali</th><th>Status</th><th>Denda</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse ($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->anggota->nama }}</td><td>{{ $peminjaman->buku->judul }}</td>
                    <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td><td>{{ $peminjaman->batas_pengembalian->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($peminjaman->status) }}</td><td>Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</td>
                    <td><a href="{{ route('peminjamans.show', $peminjaman) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="7">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $peminjamans->links() }}
</body>
</html>
