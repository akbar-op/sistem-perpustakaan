<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
</head>

<body>
    <h1>Tambah Kategori</h1>@if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif<form action="{{ route('kategoris.store') }}" method="POST">@csrf<div><label for="nama">Nama</label><input id="nama" name="nama" value="{{ old('nama') }}" required></div>
        <div><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi">{{ old('deskripsi') }}</textarea></div><button type="submit">Simpan</button><a href="{{ route('kategoris.index') }}">Batal</a>
    </form>
</body>

</html>