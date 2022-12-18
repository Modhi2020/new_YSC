<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWaqfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waqfs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->string('url_link')->nullable();
            $table->string('position')->nullable();
            $table->string('author')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('certified')->default(0);
            $table->boolean('select')->default(1);
            $table->foreignId('region_id')->nullable()->references('id')->on('regions')->onDelete('cascade');
            $table->foreignId('directorate_id')->nullable()->references('id')->on('directorates')->onDelete('cascade');
            $table->foreignId('type_id')->nullable()->references('id')->on('waqf_types')->onDelete('cascade');
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
        Schema::dropIfExists('waqfs');
    }
}
