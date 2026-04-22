<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('keranjang', function (Blueprint $table) {
        $table->decimal('harga', 10, 2)->after('gambar');
    });
}

public function down()
{
    Schema::table('keranjang', function (Blueprint $table) {
        $table->dropColumn('harga');
    });
}
};
