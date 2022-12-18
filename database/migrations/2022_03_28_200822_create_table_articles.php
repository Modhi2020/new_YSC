<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->tinyInteger('state')->default(1);
            $table->date('date');
            $table->tinyInteger('type')->default(2);
            $table->tinyInteger('ready')->default(2);
            $table->tinyInteger('sub_article')->default(2);
            $table->string('url_link')->nullable();
            $table->string('image')->nullable();
            $table->string('path')->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('author_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('articles');
    }
}
