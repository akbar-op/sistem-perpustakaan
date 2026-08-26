<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
</head>
<body>
    <h1>Tambah Buku</h1>

    @if ($errors->any())
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bukus.store') }}" method="POST">
        @csrf

        <div>
            <label for="kode_buku">Kode Buku</label>
            <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku') }}" required>
        </div>

        <div>
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
        </div>

        <div>
            <label for="penulis">Penulis</label>
            <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
        </div>

        <div>
            <label for="penerbit">Penerbit</label>
            <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" required>
        </div>

        <div>
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1" max="{{ now()->year }}">
        </div>

        <div>
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}">
        </div>

        <div>
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id">
                <option value="">Pilih kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="rak_id">Rak</label>
            <select id="rak_id" name="rak_id">
                <option value="">Pilih rak</option>
                @foreach ($raks as $rak)
                    <option value="{{ $rak->id }}" @selected(old('rak_id') == $rak->id)>{{ $rak->kode_rak }} - {{ $rak->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" value="{{ old('stok', 0) }}" min="0" required>
        </div>

        <button type="submit">Simpan Buku</button>
        <a href="{{ route('bukus.index') }}">Batal</a>
    </form>
</body>
</html>
