<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            if (! Schema::hasColumn('pesanan', 'tanggal_mulai')) {
                $table->date('tanggal_mulai')->nullable()->after('hari');
            }
            if (! Schema::hasColumn('pesanan', 'tanggal_kembali')) {
                $table->date('tanggal_kembali')->nullable()->after('tanggal_mulai');
            }
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            if (Schema::hasColumn('pesanan', 'tanggal_kembali')) {
                $table->dropColumn('tanggal_kembali');
            }
            if (Schema::hasColumn('pesanan', 'tanggal_mulai')) {
                $table->dropColumn('tanggal_mulai');
            }
        });
    }
};
