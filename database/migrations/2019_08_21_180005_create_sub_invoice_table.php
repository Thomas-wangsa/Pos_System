<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_invoice', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quantity');
            $table->string('name');
            $table->unsignedInteger('price');
            $table->string('unit')->default("Pcs");
            $table->unsignedInteger('invoice_id');
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('uuid',100)->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id', 'sub_invoice_id_byfkey')
                ->references('id')->on('invoice')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('created_by', 'sub_invoice_created_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('updated_by', 'sub_invoice_updated_by_byfkey')
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
        Schema::dropIfExists('sub_invoice');
    }
}
