<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('order', function (Blueprint $table) {
            $table->increments('id_order');
            $table->string('code_order');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('customer_phone')->nullable();
    				$table->string('customer_email')->nullable();
            $table->string('no_meja')->nullable();
            $table->integer('total_price');
            $table->string('notes')->nullable();
    				// $table->datetime('order_date');
            $table->integer('diterima')->default(0)->nullable();
            $table->integer('dikembalikan')->default(0)->nullable();
            $table->enum('stat_pemesanan',['masuk','process' , 'ready', 'selesai']);
            $table->enum('jenis_pembayaran',['ditempat' , 'online']);
            $table->enum('status',['belum bayar','menunggu verifikasi','dibayar','ditolak']);
            $table->timestamps();
            // $table->foreign('cancelled_by')->references('id')->on('users');
            $table->index('code_order');
            // $table->index(['code_order', 'order_date']);

            // $table->foreignId('user_id')->change();
            // $table->foreignId('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
