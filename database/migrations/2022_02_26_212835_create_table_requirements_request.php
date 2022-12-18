<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRequirementsRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements_request', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('title');
            $table->string('slug')->unique();
            $table->tinyInteger('type')->default(3);
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->string('url_link')->nullable();
            $table->integer('quran')->default(0);
            $table->double('price', 8, 2)->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('region_id')->nullable()->references('id')->on('regions')->onDelete('cascade');
            $table->foreignId('directorate_id')->nullable()->references('id')->on('directorates')->onDelete('cascade');
            $table->foreignId('mosque_id')->nullable()->references('id')->on('mosques')->onDelete('cascade');
            $table->string('author')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('requirements_request');
    }
}
