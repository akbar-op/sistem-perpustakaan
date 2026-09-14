<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'kategori_id',
        'rak_id',
        'stok',
    ];

    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function getStatusAttribute(): string
    {
        return $this->stok > 0 ? 'Tersedia' : 'Stok Habis';
    }

    public function peminjamans(): BelongsToMany
    {
        return $this->belongsToMany(Peminjaman::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class);
    }
}
