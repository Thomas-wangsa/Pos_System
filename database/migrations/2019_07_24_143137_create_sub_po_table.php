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
            $table->unsignedInteger('po_id');
            $table->unsignedInteger('quantity');
            $table->string('name');
            $table->unsignedInteger('price');
            $table->unsignedInteger('total');
            $table->unsignedInteger('status')->default(1);
            $table->string('uuid',100)->unique(); 
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
        Schema::dropIfExists('sub_po');
    }
}
