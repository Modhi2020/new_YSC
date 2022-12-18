<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doc_no')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('details')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
            $table->tinyInteger('type')->default(3);
            $table->tinyInteger('state')->default(2);
            $table->tinyInteger('reply')->default(2);
            $table->string('guidance')->nullable(); 
            $table->date('guidance_date')->nullable();
            $table->string('guidance_source')->nullable();
            $table->bigInteger('diary_no')->nullable();
            $table->string('position')->unique();
            $table->text('pos_details')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('outcoming_id')->unsigned()->nullable();
            $table->bigInteger('incoming_id')->unsigned()->nullable();
            $table->boolean('select')->default(1);
            $table->foreignId('from_side_id')->nullable()->references('id')->on('outgoing_sides')->onDelete('cascade');
            $table->foreignId('region_id')->nullable()->references('id')->on('regions')->onDelete('cascade');
            $table->foreignId('directorate_id')->nullable()->references('id')->on('directorates')->onDelete('cascade');
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
        Schema::dropIfExists('documentations');
    }
}
