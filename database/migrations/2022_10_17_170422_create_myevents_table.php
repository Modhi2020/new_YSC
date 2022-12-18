<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyeventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myevents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->date('date');
            $table->tinyInteger('state')->default(1);
            $table->tinyInteger('ready')->default(2);
            $table->string('url_link')->nullable();
            $table->string('files')->nullable();
            $table->bigInteger('viewers')->default(0);
            $table->boolean('select')->default(1);
            $table->integer('type')->default(2);
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('myevents');
    }
}
