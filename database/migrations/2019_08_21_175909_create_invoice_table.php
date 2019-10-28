<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->unsignedInteger('sales_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('delivery_order_id');
            $table->unsignedInteger('payment_method_id')->default(1);
            $table->date('due_date')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->unsignedInteger('status')->default(1);
            $table->string('uuid',100)->unique(); 
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('delivery_order_id', 'invoice_delivery_order_id_byfkey')
                ->references('id')->on('delivery_order')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');
                
            $table->foreign('po_id', 'invoice_po_id_byfkey')
                ->references('id')->on('po')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('customer_id', 'invoice_customer_id_byfkey')
                ->references('id')->on('customer')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('sales_id', 'invoice_sales_id_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('created_by', 'invoice_created_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');


            $table->foreign('updated_by', 'invoice_updated_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('status', 'invoice_status_byfkey')
                ->references('id')->on('delivery_order_status')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('payment_method_id', 'invoice_payment_method_id_byfkey')
                ->references('id')->on('payment_method')
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
        Schema::dropIfExists('invoice');
    }
}
