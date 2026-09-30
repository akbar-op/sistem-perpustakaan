<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class InitialBookCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Fiksi', 'Sains', 'Sejarah'] as $nama) {
            Kategori::query()->firstOrCreate(['nama' => $nama]);
        }
    }
}
