<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 11)->unique();
            $table->dateTime('tgl');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('member')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('bayar')->unsigned();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('penjualan');
    }
}
