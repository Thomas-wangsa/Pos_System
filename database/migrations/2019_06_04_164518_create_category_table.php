<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('detail');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->string('uuid',100)->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by', 'category_created_by_byfkey')
                ->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');


            $table->foreign('updated_by', 'category_updated_by_byfkey')
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
        Schema::dropIfExists('category');
    }
}
