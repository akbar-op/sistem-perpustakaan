<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Catat Peminjaman</title></head>
<body>
    <h1>Catat Peminjaman</h1>
    @if ($errors->any()) <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul> @endif
    @if ($bukus->isEmpty()) <p>Tidak ada buku yang tersedia.</p> @endif
    <form action="{{ route('peminjamans.store') }}" method="POST">
        @csrf
        <div><label for="anggota_id">Anggota</label><select id="anggota_id" name="anggota_id" required><option value="">Pilih anggota</option>@foreach ($anggotas as $anggota)<option value="{{ $anggota->id }}">{{ $anggota->nomor_anggota }} - {{ $anggota->nama }}</option>@endforeach</select></div>
        <div><label for="buku_id">Buku</label><select id="buku_id" name="buku_id" required><option value="">Pilih buku</option>@foreach ($bukus as $buku)<option value="{{ $buku->id }}">{{ $buku->kode_buku }} - {{ $buku->judul }} (stok: {{ $buku->stok }})</option>@endforeach</select></div>
        <div><label for="tanggal_pinjam">Tanggal Pinjam</label><input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', today()->toDateString()) }}" required></div>
        <div><label for="batas_pengembalian">Batas Pengembalian</label><input type="date" id="batas_pengembalian" name="batas_pengembalian" value="{{ old('batas_pengembalian', today()->addDays(7)->toDateString()) }}" required></div>
        <button type="submit" @disabled($bukus->isEmpty() || $anggotas->isEmpty())>Simpan</button><a href="{{ route('peminjamans.index') }}">Batal</a>
    </form>
</body>
</html>
