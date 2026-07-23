<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Satu akun user hanya boleh terdaftar 1x di event yang sama
            $table->unique(['event_id', 'user_id'], 'unique_user_per_event');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique('unique_user_per_event');
        });
    }
};
