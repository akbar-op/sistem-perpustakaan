<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('nis_nip');
            $table->foreignId('buku_id')->constrained('bukus');
            $table->date('tanggal_pinjam');
            $table->date('batas_pengembalian');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->string('kondisi_buku')->nullable();
            $table->string('status')->default('dipinjam');
            $table->unsignedInteger('denda')->default(0);
            $table->timestamps();

            $table->foreign('nis_nip')->references('nis_nip')->on('anggotas')->onDelete('cascade');

            $table->index(['status', 'batas_pengembalian']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
