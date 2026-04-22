<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('session_id')->nullable()->index()->after('tanggal_kembali');
            $table->string('metode_pembayaran')->nullable()->after('session_id');
            $table->string('status')->nullable()->default('pending')->after('metode_pembayaran');
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'metode_pembayaran', 'status']);
        });
    }
};
