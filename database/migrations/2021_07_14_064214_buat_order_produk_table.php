<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatOrderProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_produk', function (Blueprint $table) {
            $table->increments('id_order_produk');
            // $table->integer('id_order');
            // $table->integer('id_produk');
            // $table->integer('qty');
            // $table->decimal('subtotal',10,2);
            $table->integer('id_order')->unsigned()
                            ->references('id_order')
                            ->on('order')
                            ->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->integer('id_produk')->unsigned()
                            ->references('id_produk')
                            ->on('produk')
                            ->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->integer('id_kategori')->unsigned()
                            ->references('id_kategori')
                            ->on('kategori')
                            ->onUpdate('cascade')
                            ->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('subtotal',10,2);
            $table->enum('status_rating',['belum','sudah']);
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
        Schema::dropIfExists('order_produk');
    }
}
