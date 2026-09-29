<?php

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
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

test('book lists can be filtered by category', function () {
    $fiction = Kategori::create(['nama' => 'Fiksi']);
    $science = Kategori::create(['nama' => 'Sains']);
    Buku::create([
        'kode_buku' => 'BK-FIKSI',
        'judul' => 'Cerita Fiksi',
        'penulis' => 'Penulis A',
        'penerbit' => 'Sekolah',
        'kategori_id' => $fiction->id,
        'stok' => 2,
    ]);
    Buku::create([
        'kode_buku' => 'BK-SAINS',
        'judul' => 'Dasar Sains',
        'penulis' => 'Penulis B',
        'penerbit' => 'Sekolah',
        'kategori_id' => $science->id,
        'stok' => 1,
    ]);

    $this->get('/bukus?kategori_id='.$fiction->id)
        ->assertSuccessful()
        ->assertSee('Cerita Fiksi')
        ->assertDontSee('Dasar Sains');

    $student = User::factory()->create([
        'role' => 'siswa',
        'email' => 'catalog-student@example.com',
    ]);

    $this->actingAs($student)
        ->get('/katalog-buku?kategori_id='.$science->id)
        ->assertSuccessful()
        ->assertSee('Dasar Sains')
        ->assertDontSee('Cerita Fiksi');
});

test('book cards show stock count and availability colors by threshold', function () {
    foreach ([0, 1, 2, 4, 5, 6, 7] as $stock) {
        Buku::create([
            'kode_buku' => "BK-STOCK-{$stock}",
            'judul' => "Buku Stok {$stock}",
            'penulis' => 'Penulis',
            'penerbit' => 'Sekolah',
            'stok' => $stock,
        ]);
    }

    $this->get('/bukus')
        ->assertSuccessful()
        ->assertSee('Buku Habis')
        ->assertSee('Tersisa 0 buku')
        ->assertSee('Tersisa 1 buku')
        ->assertSee('Tersisa 7 buku')
        ->assertSee('bg-gray-100 text-gray-700', false)
        ->assertSee('bg-red-50 text-red-700', false)
        ->assertSee('bg-amber-50 text-amber-800', false)
        ->assertSee('bg-emerald-50 text-emerald-700', false)
        ->assertSee('bg-slate-100 text-slate-700', false);
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
    ])->assertRedirect('/peminjamans?status=dikembalikan');

    $this->get('/peminjamans?status=dikembalikan')
        ->assertSuccessful()
        ->assertSee('Riwayat pengembalian')
        ->assertSee('Siti')
        ->assertSee('Pemrograman Laravel')
        ->assertSee('27-08-2026');

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

test('students can view only their borrowing history and update their profile', function () {
    $student = User::factory()->create([
        'role' => 'siswa',
        'email' => 'student@example.com',
    ]);
    $studentMember = Anggota::create([
        'nomor_anggota' => 'AG-STUDENT',
        'nama' => 'Siti Student',
        'jenis_anggota' => 'siswa',
        'nis_nip' => 'ST-001',
        'email' => 'student@example.com',
        'aktif' => true,
    ]);
    $otherMember = Anggota::create([
        'nomor_anggota' => 'AG-OTHER',
        'nama' => 'Other Student',
        'jenis_anggota' => 'siswa',
        'nis_nip' => 'ST-002',
        'email' => 'other@example.com',
        'aktif' => true,
    ]);
    $ownedBook = Buku::create([
        'kode_buku' => 'BK-OWNED',
        'judul' => 'Buku Milik Saya',
        'penulis' => 'Penulis',
        'penerbit' => 'Sekolah',
        'stok' => 0,
    ]);
    $otherBook = Buku::create([
        'kode_buku' => 'BK-OTHER',
        'judul' => 'Buku Milik Orang Lain',
        'penulis' => 'Penulis',
        'penerbit' => 'Sekolah',
        'stok' => 0,
    ]);
    Peminjaman::create([
        'nis_nip' => $studentMember->nis_nip,
        'buku_id' => $ownedBook->id,
        'tanggal_pinjam' => '2026-09-01',
        'batas_pengembalian' => '2026-09-08',
        'status' => 'dipinjam',
    ]);
    Peminjaman::create([
        'nis_nip' => $otherMember->nis_nip,
        'buku_id' => $otherBook->id,
        'tanggal_pinjam' => '2026-09-01',
        'batas_pengembalian' => '2026-09-08',
        'status' => 'dipinjam',
    ]);

    $this->actingAs($student)
        ->get('/')
        ->assertRedirect(route('katalog-buku.index'));

    $this->get('/peminjaman-saya')
        ->assertSuccessful()
        ->assertSee('Buku Milik Saya')
        ->assertDontSee('Buku Milik Orang Lain');

    $this->get('/katalog-buku')
        ->assertSuccessful()
        ->assertSee('grid gap-6 sm:grid-cols-2 xl:grid-cols-4', false)
        ->assertSee('Detail')
        ->assertSee('Peminjaman')
        ->assertSee('Profil')
        ->assertDontSee('Pengaturan');
    $this->get(route('katalog-buku.show', $ownedBook))
        ->assertSuccessful()
        ->assertSee('Buku Milik Saya')
        ->assertDontSee('Edit Buku');
    $this->get('/profil')->assertSuccessful();
    $this->get('/dashboard')->assertForbidden();
    $this->get('/laporan')->assertForbidden();
    $this->get('/bukus')->assertForbidden();
    $this->get('/peminjamans')->assertForbidden();
    $this->get('/setting')->assertForbidden();

    $this->put('/profil', [
        'name' => 'Siti Updated',
        'email' => 'student@example.com',
    ])->assertRedirect('/profil');

    expect($student->fresh()->name)->toBe('Siti Updated');
});

test('students cannot see borrowing records when member email mapping is ambiguous', function () {
    $student = User::factory()->create([
        'role' => 'siswa',
        'email' => 'student@example.com',
    ]);

    foreach (['AG-MATCH-1', 'AG-MATCH-2'] as $index => $number) {
        Anggota::create([
            'nomor_anggota' => $number,
            'nama' => "Student {$index}",
            'jenis_anggota' => 'siswa',
            'nis_nip' => "ST-00{$index}",
            'email' => 'student@example.com',
            'aktif' => true,
        ]);
    }

    $this->actingAs($student)
        ->get('/peminjaman-saya')
        ->assertForbidden();
});
