<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirms', function (Blueprint $table) {
            $table->increments('id_confirm');
            $table->integer('user_id')->unsigned();
                  // ->references('id')
                  // ->on('users')
                  // ->onUpdate('cascade')
                  // ->onDelete('cascade');
            $table->integer('id_order')->unsigned();
                  // ->references('id_order')
                  // ->on('order')
                  // ->onUpdate('cascade')
                  // ->onDelete('cascade');
            $table->string('status_order')->default('NULL');
            $table->text('image');
            $table->timestamps();
        });

        // Schema::table('confirms', function (Blueprint $table) {
        //   $table->foreign('user_id')
        //       ->references('id')
        //       ->on('users')
        //       ->onUpdate('cascade')
        //       ->onDelete('cascade');
        //
        //   $table->foreign('order_id')
        //       ->references('order_id')
        //       ->on('order')
        //       ->onUpdate('cascade')
        //       ->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirms');
    }
}
