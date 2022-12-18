<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('id');
            $table->integer('role_id')->unsigned();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('image')->default('default.png');
            $table->string('about')->nullable();
            $table->string('password');
            $table->string('slug')->unique()->nullable();
            $table->text('roles_name')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->text('address')->nullable();
            $table->boolean('status')->default(1); 
            $table->string('logo')->nullable();
            $table->string('path')->nullable();
            $table->boolean('select')->default(1);
            $table->rememberToken();
            $table->timestamps();
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
