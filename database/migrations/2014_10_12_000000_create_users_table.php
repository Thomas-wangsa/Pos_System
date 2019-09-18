<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',40);
            $table->string('email')->unique();
            $table->string('phone',100)->nullable();
            $table->unsignedInteger('role');   
            $table->string('password');
            $table->string('uuid',100)->unique(); 
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role', 'users_fkey')
                ->references('id')->on('user_role')
                ->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->foreign('created_by', 'users_created_byfkey')
                ->references('id')->on('users')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');

            $table->foreign('updated_by', 'users_updated_byfkey')
                ->references('id')->on('users')
                ->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
