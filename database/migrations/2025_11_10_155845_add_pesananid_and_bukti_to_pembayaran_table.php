<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->unsignedBigInteger('pesanan_id')->nullable()->after('user_id');
            $table->string('bukti')->nullable()->after('tanggal_pembayaran');

            // optional foreign key:
            // $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            // if foreign key used: $table->dropForeign(['pesanan_id']);
            $table->dropColumn(['pesanan_id', 'bukti']);
        });
    }
};
