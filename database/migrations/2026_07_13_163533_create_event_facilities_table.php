<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('nama_fasilitas'); // Jersey Balapan, Medali Finisher, dll
            $table->string('icon')->nullable(); // nama icon (misal: shirt, medal)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_facilities');
    }
};