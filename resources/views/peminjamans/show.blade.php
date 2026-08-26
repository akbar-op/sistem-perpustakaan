<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Detail Peminjaman</title></head>
<body>
    <h1>Detail Peminjaman</h1>
    <p>Anggota: {{ $peminjaman->anggota->nama }}</p>
    <p>Buku: {{ $peminjaman->buku->judul }}</p>
    <p>Tanggal pinjam: {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</p>
    <p>Batas pengembalian: {{ $peminjaman->batas_pengembalian->format('d-m-Y') }}</p>
    <p>Status: {{ ucfirst($peminjaman->status) }}</p>

    @if ($peminjaman->status === 'dipinjam')
        <h2>Catat Pengembalian</h2>
        <form action="{{ route('peminjamans.kembalikan', $peminjaman) }}" method="POST">
            @csrf
            <div><label for="tanggal_dikembalikan">Tanggal Dikembalikan</label><input type="date" id="tanggal_dikembalikan" name="tanggal_dikembalikan" value="{{ today()->toDateString() }}" required></div>
            <div><label for="kondisi_buku">Kondisi Buku</label><select id="kondisi_buku" name="kondisi_buku" required><option value="baik">Baik</option><option value="rusak">Rusak</option><option value="hilang">Hilang</option></select></div>
            <button type="submit">Simpan Pengembalian</button>
        </form>
    @else
        <p>Dikembalikan: {{ $peminjaman->tanggal_dikembalikan->format('d-m-Y') }}</p>
        <p>Kondisi: {{ ucfirst($peminjaman->kondisi_buku) }}</p>
        <p>Denda: Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</p>
    @endif
    <a href="{{ route('peminjamans.index') }}">Kembali</a>
</body>
</html>
