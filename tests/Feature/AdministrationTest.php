<?php

use App\Models\Buku;
use App\Models\User;

test('admin and petugas can log in', function () {
    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'role' => 'admin',
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

test('petugas cannot manage categories', function () {
    $this->actingAs(User::factory()->create(['role' => 'petugas']))
        ->get('/kategoris')
        ->assertForbidden();
});

test('admin can see dashboard statistics and export book report', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
    Buku::create([
        'kode_buku' => 'BK-ADMIN',
        'judul' => 'Buku Administrasi',
        'penulis' => 'Admin',
        'penerbit' => 'Sekolah',
        'stok' => 3,
    ]);

    $this->get('/dashboard')
        ->assertSuccessful()
        ->assertSee('Total judul buku');

    $this->get('/laporan/buku/excel')
        ->assertSuccessful()
        ->assertHeader('content-type', 'application/vnd.ms-excel; charset=UTF-8')
        ->assertSee('Buku Administrasi');
});

test('kepala sekolah can only review borrowing reports', function () {
    $this->actingAs(User::factory()->create(['role' => 'kepala_sekolah']));

    $this->get('/dashboard')
        ->assertSuccessful()
        ->assertSee('Laporan Peminjaman')
        ->assertDontSee('Buku</a>');

    $this->get('/laporan')
        ->assertSuccessful()
        ->assertSee('Laporan Peminjaman')
        ->assertDontSee('Laporan Buku');

    $this->get('/laporan/peminjaman/excel')->assertSuccessful();
    $this->get('/laporan/buku/excel')->assertForbidden();
    $this->get('/bukus')->assertForbidden();
});
