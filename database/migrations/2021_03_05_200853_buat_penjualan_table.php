<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->increments('id_penjualan');
            $table->string('code_order')->unique();
            // $table->integer('qty');
            $table->integer('total_price');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            // $table->tinyInteger('diskon')->default(0);
            $table->string('notes')->nullable();
            $table->integer('bayar')->default(0);
            $table->integer('diterima')->default(0);
            $table->string('jenis_pembayaran')->default("di_tempat");
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
