<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'nis_nip',
        'buku_id',
        'tanggal_pinjam',
        'batas_pengembalian',
        'tanggal_dikembalikan',
        'kondisi_buku',
        'status',
        'denda',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'batas_pengembalian' => 'date',
            'tanggal_dikembalikan' => 'date',
            'denda' => 'integer',
        ];
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'nis_nip', 'nis_nip');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
}
