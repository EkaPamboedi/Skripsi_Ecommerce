<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
          $table->increments('id_payments');
            // $table->integer('id_order')->unsigned();
            // $table->string('code')->unique();
            $table->unsignedBigInteger('code_order')
                            ->references('code_order')
                            ->on('order');
    				$table->string('number')->unique();
    				$table->decimal('amount', 16, 2)->default(0);
    				$table->string('method');
    				$table->string('token')->nullable();
    				$table->json('payloads')->nullable();
    				$table->string('payment_type')->nullable();
    				$table->string('va_number')->nullable();
    				$table->string('vendor_name')->nullable();
    				$table->string('biller_code')->nullable();
    				$table->string('bill_key')->nullable();
    				$table->softDeletes();
    				$table->timestamps();

    				// $table->foreign('code_order')->references('code_order')->on('order');
            // $table->foreign('code_order')
            //                 ->references('code_order')
            //                 ->on('order')
            //                 ->unsigned();
                            // ->onUpdate('cascade')
                            // ->onDelete('cascade');
            // $table->foreign('code_order')
            //     ->references('code_order')
            //     ->on('order')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');
    				$table->index('number');
    				$table->index('method')->nullable();
    				$table->index('token');
    				$table->index('payment_type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
