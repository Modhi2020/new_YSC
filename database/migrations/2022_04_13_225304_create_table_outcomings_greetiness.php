<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOutcomingsGreetiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcomings_greetiness', function (Blueprint $table) {
            $table->id();
            $table->date('delivery')->nullable();
            $table->tinyInteger('state')->default(2);
            $table->text('details')->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('outcoming_id')->nullable()->references('id')->on('outcomings')->onDelete('cascade');
            $table->foreignId('to_side_id')->nullable()->references('id')->on('outgoing_sides')->onDelete('cascade');
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
        Schema::dropIfExists('outcomings_greetiness');
    }
}
