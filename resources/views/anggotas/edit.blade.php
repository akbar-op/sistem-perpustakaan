<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Edit Anggota</title></head>
<body>
    <h1>Edit Anggota</h1>
    @if ($errors->any()) <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul> @endif
    <form action="{{ route('anggotas.update', $anggota) }}" method="POST">
        @csrf @method('PUT')
        <div><label for="nomor_anggota">Nomor Anggota</label><input type="text" id="nomor_anggota" name="nomor_anggota" value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}" required></div>
        <div><label for="nama">Nama</label><input type="text" id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}" required></div>
        <div><label for="jenis_anggota">Jenis</label><select id="jenis_anggota" name="jenis_anggota" required><option value="siswa" @selected(old('jenis_anggota', $anggota->jenis_anggota) === 'siswa')>Siswa</option><option value="guru" @selected(old('jenis_anggota', $anggota->jenis_anggota) === 'guru')>Guru</option></select></div>
        <div><label for="nis_nip">NIS/NIP</label><input type="text" id="nis_nip" name="nis_nip" value="{{ old('nis_nip', $anggota->nis_nip) }}"></div>
        <div><label for="kelas">Kelas</label><input type="text" id="kelas" name="kelas" value="{{ old('kelas', $anggota->kelas) }}"></div>
        <div><label for="no_telepon">Nomor Telepon</label><input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}"></div>
        <label><input type="checkbox" name="aktif" value="1" @checked(old('aktif', $anggota->aktif))> Aktif</label>
        <button type="submit">Simpan</button><a href="{{ route('anggotas.index') }}">Batal</a>
    </form>
</body>
</html>
