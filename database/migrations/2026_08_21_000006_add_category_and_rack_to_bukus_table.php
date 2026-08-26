<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('isbn')->constrained('kategoris')->nullOnDelete();
            $table->foreignId('rak_id')->nullable()->after('kategori_id')->constrained('raks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['rak_id']);
            $table->dropColumn(['kategori_id', 'rak_id']);
        });
    }
};
