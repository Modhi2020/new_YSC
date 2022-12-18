<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('details');
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->string('url_link')->nullable();
            $table->tinyInteger('service_order')->default(1);
            $table->tinyInteger('ready')->default(2);
            $table->boolean('select')->default(1);
            $table->string('publisher')->nullable();
            $table->foreignId('publisher_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->references('id')->on('programs')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('courses');
    }
}
