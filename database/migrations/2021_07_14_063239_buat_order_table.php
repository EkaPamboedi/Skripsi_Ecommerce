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
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('code_order')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('customer_phone')->nullable();
    				$table->string('customer_email')->nullable();
            $table->text('no_meja');
            $table->integer('total_price');
            $table->string('notes')->nullable();
    				$table->datetime('order_date');
            // $table->datetime('payment_due');
    				// $table->string('payment_status');
    				// $table->text('note')->nullable();
            $table->enum('status',['belum bayar','menunggu verifikasi','dibayar','ditolak']);
            $table->timestamps();
            // $table->foreign('cancelled_by')->references('id')->on('users');
            $table->index('code_order');
            $table->index(['code_order', 'order_date']);

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
