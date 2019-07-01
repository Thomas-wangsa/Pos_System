<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('owner')->nullable();
            $table->string('adrress')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->uuid('uuid'); 
            $table->text('comment')->nullable();
            $table->timestamp('relation_at')->nullable();
            $table->timestamp('relation_end')->nullable();  
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
        Schema::dropIfExists('customer');
    }
}
