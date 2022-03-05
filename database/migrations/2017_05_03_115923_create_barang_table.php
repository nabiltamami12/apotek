<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 7)->unique();
            $table->string('barcode', 20)->unique();
            $table->string('nama', 100)->unique();
            $table->integer('jenis_id')->unsigned();
            $table->foreign('jenis_id')->references('id')->on('jenis')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('harga_beli')->unsigned();
            $table->integer('pembulatan')->unsigned();
            $table->integer('markup_1')->unsigned();
            $table->integer('rp_1')->unsigned();
            $table->integer('harga_jual_1')->unsigned();
            $table->integer('markup_2')->unsigned();
            $table->integer('rp_2')->unsigned();
            $table->integer('harga_jual_2')->unsigned();
            $table->integer('markup_3')->unsigned();
            $table->integer('rp_3')->unsigned();
            $table->integer('harga_jual_3')->unsigned();
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
