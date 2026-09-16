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
        Schema::table('produk', function (Blueprint $table) {
            if (!Schema::hasColumn('produk', 'jenis_produk_id')) {
                $table->foreignId('jenis_produk_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('jenis_produks')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            if (Schema::hasColumn('produk', 'jenis_produk_id')) {
                $table->dropConstrainedForeignId('jenis_produk_id');
            }
        });
    }
};
