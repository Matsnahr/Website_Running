<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kota');
            $table->string('kategori'); // 3K, 5K, 10K, Half Marathon, Full Marathon
            $table->decimal('jarak_km', 5, 2);
            $table->date('tanggal');
            $table->time('waktu_mulai');
            $table->decimal('harga', 10, 2);
            $table->decimal('early_bird_harga', 10, 2)->nullable();
            $table->date('early_bird_deadline')->nullable();
            $table->integer('kuota');
            $table->integer('terisi')->default(0);
            $table->enum('status', ['draft', 'aktif', 'selesai'])->default('draft');
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('lokasi_detail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};