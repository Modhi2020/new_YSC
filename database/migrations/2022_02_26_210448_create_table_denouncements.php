<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDenouncements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denouncements', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->tinyInteger('type')->default(2);
            $table->string('url_link')->nullable();
            $table->string('position')->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('region_id')->nullable()->references('id')->on('regions')->onDelete('cascade');
            $table->foreignId('directorate_id')->nullable()->references('id')->on('directorates')->onDelete('cascade');
            $table->foreignId('complaint_id')->nullable()->references('id')->on('complaints')->onDelete('cascade');
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
        Schema::dropIfExists('denouncements');
    }
}
