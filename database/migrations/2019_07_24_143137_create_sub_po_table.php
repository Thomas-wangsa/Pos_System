<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_po', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quantity');
            $table->string('name');
            $table->unsignedInteger('price');
            $table->unsignedInteger('status')->default(2);
            $table->unsignedInteger('po_id');
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('uuid',100)->unique(); 
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('po_id', 'sub_po_id_byfkey')
                ->references('id')->on('po')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('status', 'sub_po_status_byfkey')
                ->references('id')->on('sub_po_status')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('created_by', 'sub_po_created_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');


            $table->foreign('updated_by', 'sub_po_updated_by_byfkey')
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
        Schema::dropIfExists('sub_po');
    }
}
