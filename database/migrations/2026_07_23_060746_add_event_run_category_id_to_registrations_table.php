<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Nullable FK — null = event lama tanpa multi-kategori
            $table->foreignId('event_run_category_id')
                ->nullable()
                ->constrained('event_run_categories')
                ->nullOnDelete()
                ->after('event_id');

            // Simpan nominal dan diskon agar mudah tampil di admin
            $table->decimal('nominal_bayar', 10, 2)->nullable()->after('total_bayar');
            $table->decimal('diskon', 10, 2)->default(0)->after('nominal_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['event_run_category_id']);
            $table->dropColumn(['event_run_category_id', 'nominal_bayar', 'diskon']);
        });
    }
};
