<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignIdToOrderProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_produk', function (Blueprint $table) {
          $table->foreign('id_order')
              ->references('id_order')
              ->on('order')
              ->onUpdate('cascade')
              ->onDelete('cascade');

          $table->foreign('id_produk')
              ->references('id_produk')
              ->on('produk')
              ->onUpdate('cascade')
              ->onDelete('cascade');

          $table->foreign('id_kategori')
              ->references('id_kategori')
              ->on('kategori')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_produk', function (Blueprint $table) {
          $table->foreign('id_order')
              ->references('id_order')
              ->on('order')
              ->onUpdate('cascade')
              ->onDelete('cascade');

          $table->foreign('id_produk')
              ->references('id_produk')
              ->on('produk')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        });
    }
}
