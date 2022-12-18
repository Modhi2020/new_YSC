<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOutcomings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outcomings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('outcoming_no')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->string('description')->nullable();
            $table->string('greetiness')->nullable();
            $table->date('date');
            $table->tinyInteger('type')->default(3);
            $table->tinyInteger('state')->default(2);
            $table->date('delivery')->nullable();
            $table->bigInteger('incoming_id')->unsigned()->nullable();
            // $table->foreignId('from_side_id')->nullable()->references('id')->on('outgoing_sides')->onDelete('cascade');
            $table->foreignId('to_side_id')->nullable()->references('id')->on('outgoing_sides')->onDelete('cascade');
            $table->boolean('select')->default(1);
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
        Schema::dropIfExists('outcomings');
    }
}
