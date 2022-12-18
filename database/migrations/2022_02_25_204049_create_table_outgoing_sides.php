<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOutgoingSides extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_sides', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('ready')->default(2);
            $table->tinyInteger('state')->default(1);
            $table->boolean('select')->default(1);
            $table->string('path')->nullable();
            $table->foreignId('side_id')->nullable()->references('id')->on('outgoing_sides')->onDelete('cascade');
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
        Schema::dropIfExists('outgoing_sides');
    }
}
