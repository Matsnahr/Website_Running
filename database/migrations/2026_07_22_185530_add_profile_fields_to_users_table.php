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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->after('email');
            $table->string('no_hp', 20)->nullable()->after('nik');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('no_hp');
            $table->string('ukuran_jersey', 5)->nullable()->after('jenis_kelamin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'no_hp', 'jenis_kelamin', 'ukuran_jersey']);
        });
    }
};
