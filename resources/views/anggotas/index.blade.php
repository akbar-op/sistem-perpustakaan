<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Data Anggota</title></head>
<body>
    <h1>Data Anggota</h1>
    @if (session('success')) <p>{{ session('success') }}</p> @endif
    @if (session('error')) <p>{{ session('error') }}</p> @endif
    <a href="{{ route('anggotas.create') }}">Tambah Anggota</a>
    <a href="{{ route('bukus.index') }}">Buku</a>
    <a href="{{ route('peminjamans.index') }}">Peminjaman</a>

    <form action="{{ route('anggotas.index') }}" method="GET">
        <label for="search">Cari anggota</label>
        <input type="search" id="search" name="search" value="{{ $search }}" placeholder="Nama, nomor, atau NIS/NIP">
        <button type="submit">Cari</button>
    </form>

    <table>
        <thead><tr><th>Nomor</th><th>Nama</th><th>Jenis</th><th>NIS/NIP</th><th>Kelas</th><th>Telepon</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse ($anggotas as $anggota)
                <tr>
                    <td>{{ $anggota->nomor_anggota }}</td><td>{{ $anggota->nama }}</td><td>{{ ucfirst($anggota->jenis_anggota) }}</td>
                    <td>{{ $anggota->nis_nip ?? '-' }}</td><td>{{ $anggota->kelas ?? '-' }}</td><td>{{ $anggota->no_telepon ?? '-' }}</td>
                    <td>{{ $anggota->aktif ? 'Aktif' : 'Tidak aktif' }}</td>
                    <td>
                        <a href="{{ route('anggotas.edit', $anggota) }}">Edit</a>
                        <form action="{{ route('anggotas.destroy', $anggota) }}" method="POST" style="display: inline">
                            @csrf @method('DELETE') <button type="submit" onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">Belum ada data anggota.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $anggotas->links() }}
</body>
</html>
