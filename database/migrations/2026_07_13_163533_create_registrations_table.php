<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('no_bib')->nullable()->unique();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_hp');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('ukuran_jersey', ['S', 'M', 'L', 'XL', 'XXL']);
            $table->string('kode_kupon')->nullable();
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status_bayar', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};