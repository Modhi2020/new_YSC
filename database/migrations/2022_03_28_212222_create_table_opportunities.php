<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOpportunities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->date('date');
            $table->tinyInteger('state')->default(1);
            $table->date('start_time')->nullable()->default(date('Y-m-d'));
            $table->date('end_time')->nullable()->default(date('Y-m-d'));
            $table->tinyInteger('submit_method')->default(2);
            $table->tinyInteger('type')->default(2);
            $table->tinyInteger('ready')->default(2);
            $table->string('url_link')->nullable();
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('location_id')->nullable()->references('id')->on('cities')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->references('id')->on('programs')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('opportunities');
    }
}
