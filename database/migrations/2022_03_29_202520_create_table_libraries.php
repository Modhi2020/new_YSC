<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLibraries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('details')->nullable();
            $table->date('date');
            $table->tinyInteger('type')->default(2);
            $table->tinyInteger('ready')->default(2);
            $table->string('url_link')->nullable();
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->string('file')->nullable();
            $table->string('file_path')->nullable();
            $table->string('author')->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('author_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('libraries');
    }
}
