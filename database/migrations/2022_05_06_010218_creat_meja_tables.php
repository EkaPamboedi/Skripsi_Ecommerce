<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatMejaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('tables', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('id_order')->unsigned()->nullable();
        $table->integer('code_order')->unsigned()->nullable();
        // $table->integer('no_meja');
        $table->integer('no_meja')->nullable();
        $table->string('link')->nullable();
        $table->string('level')->nullable();
        $table->timestamps();
      });

      Schema::table('tables', function (Blueprint $table) {
          // $table->integer('id_meja')->after('id');

          $table->foreign('id_order')
              ->references('id_order')
              ->on('order')
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
      Schema::dropIfExists('tables');
    }
}
