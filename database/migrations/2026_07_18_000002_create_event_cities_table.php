<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_cities', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // e.g. "Jakarta", "Bandung"
            $table->string('provinsi')->nullable(); // e.g. "DKI Jakarta", "Jawa Barat"
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_cities');
    }
};
