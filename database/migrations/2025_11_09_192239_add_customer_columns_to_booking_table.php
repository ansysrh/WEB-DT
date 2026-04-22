<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerColumnsToBookingTable extends Migration
{
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('user_id');
            $table->string('whatsapp')->nullable()->after('nama');
            $table->string('email')->nullable()->after('whatsapp');
            $table->integer('hari')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['nama', 'whatsapp', 'email', 'hari']);
        });
    }
}
