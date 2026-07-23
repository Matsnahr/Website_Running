<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tambah kolom NIK ke tabel registrations.
     * Unique per kombinasi event_id + nik agar 1 NIK tidak bisa daftar event yang sama 2x.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Tambahkan kolom NIK setelah no_hp
            $table->string('nik', 16)->nullable()->after('no_hp');

            // Unique constraint: satu NIK hanya bisa daftar satu kali per event
            $table->unique(['event_id', 'nik'], 'unique_nik_per_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique('unique_nik_per_event');
            $table->dropColumn('nik');
        });
    }
};
