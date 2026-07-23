<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_run_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('nama');               // e.g. "5K", "10K", "21K Fun Run"
            $table->decimal('jarak_km', 5, 2)->nullable();
            $table->decimal('harga', 10, 2);
            $table->integer('kuota');
            $table->integer('terisi')->default(0);
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0); // untuk sorting tampilan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_run_categories');
    }
};
