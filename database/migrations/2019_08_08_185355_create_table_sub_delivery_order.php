<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubDeliveryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_delivery_order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('delivery_order_id');
            $table->unsignedInteger('quantity');
            $table->string('name');
            $table->unsignedInteger('status')->default(1);
            $table->uuid('uuid'); 
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_delivery_order');
    }
}
