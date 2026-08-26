<?php

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create(['role' => 'petugas']));
});

test('books can be searched by title author or code', function () {
    Buku::create([
        'kode_buku' => 'BK-001',
        'judul' => 'Pemrograman Laravel',
        'penulis' => 'Andi',
        'penerbit' => 'Sekolah',
        'stok' => 2,
    ]);
    Buku::create([
        'kode_buku' => 'BK-002',
        'judul' => 'Matematika Dasar',
        'penulis' => 'Budi',
        'penerbit' => 'Sekolah',
        'stok' => 1,
    ]);

    $this->get('/bukus?search=Laravel')
        ->assertSuccessful()
        ->assertSee('Pemrograman Laravel')
        ->assertDontSee('Matematika Dasar');
});

test('borrowing decreases stock and returning increases it', function () {
    $anggota = Anggota::create([
        'nomor_anggota' => 'AG-001',
        'nama' => 'Siti',
        'jenis_anggota' => 'siswa',
        'nis_nip' => '12345',
        'kelas' => '7A',
        'aktif' => true,
    ]);
    $buku = Buku::create([
        'kode_buku' => 'BK-001',
        'judul' => 'Pemrograman Laravel',
        'penulis' => 'Andi',
        'penerbit' => 'Sekolah',
        'stok' => 1,
    ]);

    $this->post('/peminjamans', [
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => '2026-08-21',
        'batas_pengembalian' => '2026-08-28',
    ])->assertRedirect('/peminjamans');

    expect($buku->fresh()->stok)->toBe(0);
    $peminjaman = Peminjaman::firstOrFail();

    $this->post("/peminjamans/{$peminjaman->id}/kembalikan", [
        'tanggal_dikembalikan' => '2026-08-27',
        'kondisi_buku' => 'baik',
    ])->assertRedirect('/peminjamans');

    expect($buku->fresh()->stok)->toBe(1)
        ->and($peminjaman->fresh()->status)->toBe('dikembalikan')
        ->and($peminjaman->fresh()->denda)->toBe(0);
});

test('borrowing cannot use a book with no stock', function () {
    $anggota = Anggota::create([
        'nomor_anggota' => 'AG-001',
        'nama' => 'Siti',
        'jenis_anggota' => 'siswa',
        'aktif' => true,
    ]);
    $buku = Buku::create([
        'kode_buku' => 'BK-001',
        'judul' => 'Pemrograman Laravel',
        'penulis' => 'Andi',
        'penerbit' => 'Sekolah',
        'stok' => 0,
    ]);

    $this->post('/peminjamans', [
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => '2026-08-21',
        'batas_pengembalian' => '2026-08-28',
    ])->assertUnprocessable();

    expect(Peminjaman::count())->toBe(0)
        ->and($buku->fresh()->stok)->toBe(0);
});
