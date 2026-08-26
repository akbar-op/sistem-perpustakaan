<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@perpustakaan.test',
            'password' => 'password',
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
    }
}
