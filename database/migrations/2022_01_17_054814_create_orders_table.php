<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');  
            $table->string('fname');
            $table->string('lname');
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->string('zip');
            $table->string('pnumber');
            $table->decimal('total', 20, 6);
            $table->enum('status', ['pending', 'processing', 'completed', 'decline'])->default('pending'); 
            $table->boolean('payment_status')->default(1);
            $table->string('payment_method');
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
        Schema::dropIfExists('orders');
    }
}
