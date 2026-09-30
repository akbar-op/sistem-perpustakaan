<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
</head>

<body>
    <h1>Edit Kategori</h1>@if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif<form action="{{ route('kategoris.update', $kategori) }}" method="POST">@csrf @method('PUT')<div><label for="nama">Nama</label><input id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required></div>
        <div><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $kategori->deskripsi) }}</textarea></div><button type="submit">Simpan</button><a href="{{ route('kategoris.index') }}">Batal</a>
    </form>
</body>

</html>