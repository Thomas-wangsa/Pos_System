<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDeliveryOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('driver_id');
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('sales_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->unsignedInteger('status')->default(1);
            $table->string('uuid',100)->unique(); 
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_id', 'delivery_order_driver_id_byfkey')
                ->references('id')->on('driver')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');
                
            $table->foreign('po_id', 'delivery_order_po_id_byfkey')
                ->references('id')->on('po')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('customer_id', 'delivery_order_customer_id_byfkey')
                ->references('id')->on('customer')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('sales_id', 'delivery_order_sales_id_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('created_by', 'delivery_order_created_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');


            $table->foreign('updated_by', 'delivery_order_updated_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('status', 'delivery_order_status_byfkey')
                ->references('id')->on('delivery_order_status')
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
        Schema::dropIfExists('delivery_order');
    }
}
