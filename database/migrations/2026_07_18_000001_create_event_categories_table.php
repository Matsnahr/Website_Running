<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // e.g. "3K", "5K", "10K", "Half Marathon", "Full Marathon"
            $table->decimal('jarak_km_default', 5, 2)->nullable(); // jarak default untuk kategori ini
            $table->integer('urutan')->default(0); // untuk sorting tampilan
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_categories');
    }
};
