<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@perpustakaan.test',
            'password' => 'etmin gantenk',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@perpustakaan.test',
            'password' => 'password',
            'role' => 'petugas',
        ]);

        User::factory()->create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepala.sekolah@perpustakaan.test',
            'password' => 'password',
            'role' => 'kepala_sekolah',
        ]);

        User::factory()->create([
            'name' => 'Siswa Perpustakaan',
            'email' => 'siswa@perpustakaan.test',
            'password' => 'password',
            'role' => 'siswa',
        ]);

        $books = [
            ['kode_buku' => 'BK-001', 'judul' => 'Teknologi Informasi Pendidikan', 'penulis' => 'Dosen', 'penerbit' => 'UMS Press', 'tahun_terbit' => 2024, 'stok' => 10],
            ['kode_buku' => 'BK-002', 'judul' => 'Sejarah Dunia Yang Disembunyikan', 'penulis' => 'Jonathan Black', 'penerbit' => 'History House', 'tahun_terbit' => 2023, 'stok' => 7],
            ['kode_buku' => 'BK-003', 'judul' => 'Filsafat Ilmu Pengetahuan', 'penulis' => 'Amal', 'penerbit' => 'Pustaka Ilmu', 'tahun_terbit' => 2022, 'stok' => 5],
            ['kode_buku' => 'BK-004', 'judul' => 'Sejarah Indonesia Masa Merdeka', 'penulis' => 'Dr. Aman, M.Pd', 'penerbit' => 'Balai Buku', 'tahun_terbit' => 2021, 'stok' => 8],
            ['kode_buku' => 'BK-005', 'judul' => 'Sejarah Indonesia', 'penulis' => 'Ari', 'penerbit' => 'Buku Sejarah', 'tahun_terbit' => 2020, 'stok' => 4],
        ];

        foreach ($books as $book) {
            Buku::query()->firstOrCreate(
                ['kode_buku' => $book['kode_buku']],
                $book
            );
        }

        $anggotas = [
            ['nomor_anggota' => 'A-001', 'nis_nip' => '2022001', 'nama' => 'Asep', 'jenis_anggota' => 'Siswa', 'kelas' => 'XII', 'email' => 'asep@example.com', 'aktif' => true],
            ['nomor_anggota' => 'A-002', 'nis_nip' => '2022002', 'nama' => 'Mulyono', 'jenis_anggota' => 'Siswa', 'kelas' => 'XII', 'email' => 'mulyono@example.com', 'aktif' => true],
            ['nomor_anggota' => 'A-003', 'nis_nip' => '2022003', 'nama' => 'Agus', 'jenis_anggota' => 'Siswa', 'kelas' => 'XI', 'email' => 'agus@example.com', 'aktif' => true],
            ['nomor_anggota' => 'A-004', 'nis_nip' => '2022004', 'nama' => 'Reza', 'jenis_anggota' => 'Siswa', 'kelas' => 'XI', 'email' => 'reza@example.com', 'aktif' => true],
            ['nomor_anggota' => 'A-005', 'nis_nip' => '2022005', 'nama' => 'Kevin', 'jenis_anggota' => 'Siswa', 'kelas' => 'X', 'email' => 'kevin@example.com', 'aktif' => true],
        ];

        foreach ($anggotas as $anggota) {
            Anggota::query()->firstOrCreate(
                ['nis_nip' => $anggota['nis_nip']],
                $anggota
            );
        }

        $peminjamans = [
            ['nis_nip' => '2022001', 'buku_id' => Buku::where('kode_buku', 'BK-001')->value('id'), 'tanggal_pinjam' => '2026-07-12', 'batas_pengembalian' => '2026-07-26', 'status' => 'dipinjam'],
            ['nis_nip' => '2022002', 'buku_id' => Buku::where('kode_buku', 'BK-003')->value('id'), 'tanggal_pinjam' => '2026-08-08', 'batas_pengembalian' => '2026-08-15', 'status' => 'dipinjam'],
            ['nis_nip' => '2022003', 'buku_id' => Buku::where('kode_buku', 'BK-002')->value('id'), 'tanggal_pinjam' => '2026-01-07', 'batas_pengembalian' => '2026-07-07', 'status' => 'dipinjam'],
            ['nis_nip' => '2022004', 'buku_id' => Buku::where('kode_buku', 'BK-004')->value('id'), 'tanggal_pinjam' => '2026-02-22', 'batas_pengembalian' => '2026-02-29', 'status' => 'dipinjam'],
            ['nis_nip' => '2022005', 'buku_id' => Buku::where('kode_buku', 'BK-005')->value('id'), 'tanggal_pinjam' => '2026-08-18', 'batas_pengembalian' => '2026-08-25', 'status' => 'dipinjam'],
        ];

        foreach ($peminjamans as $peminjaman) {
            if (! empty($peminjaman['buku_id'])) {
                Peminjaman::query()->firstOrCreate(
                    [
                        'nis_nip' => $peminjaman['nis_nip'],
                        'buku_id' => $peminjaman['buku_id'],
                    ],
                    $peminjaman
                );
            }
        }
    }
}
