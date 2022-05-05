<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatPenjualanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->increments('id_penjualan_detail');
            $table->integer('id_penjualan')->unsigned()
                            ->references('id_penjualan')
                            ->on('penjualan')
                            ->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->integer('id_produk')->unsigned()
                            ->references('id_produk')
                            ->on('penjualan')
                            ->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('subtotal',10,2);
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
        Schema::dropIfExists('penjualan_detail');
    }
}
