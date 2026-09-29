<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('library_settings', function (Blueprint $table) {
            $table->id();
            $table->string('library_name')->default('Perpustakaan Sekolah');
            $table->string('address')->default('Perpustakaan Sekolah');
            $table->string('email')->default('perpustakaan@sekolah.sch.id');
            $table->string('whatsapp')->default('+62 8123456789');
            $table->unsignedSmallInteger('max_books')->default(5);
            $table->unsignedSmallInteger('loan_duration_days')->default(14);
            $table->unsignedInteger('fine_per_day')->default(5000);
            $table->unsignedSmallInteger('renewal_limit')->default(2);
            $table->boolean('email_notifications')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_settings');
    }
};
