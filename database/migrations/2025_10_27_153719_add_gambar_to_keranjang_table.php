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
        // Tambah kolom hanya jika belum ada
        if (! Schema::hasColumn('keranjang', 'gambar')) {
            Schema::table('keranjang', function (Blueprint $table) {
                $table->string('gambar')->after('nama_alat');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom hanya jika ada
        if (Schema::hasColumn('keranjang', 'gambar')) {
            Schema::table('keranjang', function (Blueprint $table) {
                $table->dropColumn('gambar');
            });
        }
    }
};
