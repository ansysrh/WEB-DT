<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananItemsTable extends Migration
{
    public function up()
    {
        Schema::create('pesanan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id')->index();
            $table->unsignedBigInteger('product_id')->nullable(); // tipe_alat_id jika ada
            $table->string('nama_alat');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga', 15, 2); // harga per hari
            $table->decimal('subtotal', 15, 2); // harga * jumlah (per hari)
            $table->timestamps();

            // jika ingin foreign key:
            // $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan_items');
    }
}
