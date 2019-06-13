<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('po_id');
            $table->string('internal_code');
            $table->string('external_code');
            $table->unsignedInteger('status');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->uuid('uuid'); 
            $table->text('comment')->nullable();
            $table->timestamp('po_date')->nullable();
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
        Schema::dropIfExists('po');
    }
}
