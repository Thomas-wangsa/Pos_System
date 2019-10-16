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
            $table->unsignedInteger('quantity');
            $table->string('name');
            $table->unsignedInteger('delivery_order_id');
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('uuid',100)->unique();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('delivery_order_id', 'sub_delivery_order_id_byfkey')
                ->references('id')->on('delivery_order')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('created_by', 'sub_delivery_order_created_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('updated_by', 'sub_delivery_order_updated_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');
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
