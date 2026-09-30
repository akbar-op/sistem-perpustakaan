<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LogicException;

class DemoStudentAccountSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            throw new LogicException('Demo student accounts cannot be created in production.');
        }

        DB::transaction(function (): void {
            User::query()->firstOrCreate(
                ['email' => 'siswa@perpustakaan.test'],
                [
                    'name' => 'Siswa Perpustakaan',
                    'password' => 'password',
                    'role' => 'siswa',
                ]
            );

            Anggota::query()->firstOrCreate(
                ['nis_nip' => 'S-DEMO-001'],
                [
                    'nomor_anggota' => 'S-DEMO-001',
                    'nama' => 'Siswa Perpustakaan',
                    'jenis_anggota' => 'siswa',
                    'kelas' => 'X',
                    'email' => 'siswa@perpustakaan.test',
                    'aktif' => true,
                ]
            );
        });
    }
}
