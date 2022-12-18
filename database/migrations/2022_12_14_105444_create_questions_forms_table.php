<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_forms', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->foreignId('checkbox_id')->nullable()->references('id')->on('checkbox_questions')->onDelete('cascade');
            $table->foreignId('essay_id')->nullable()->references('id')->on('essay_questions')->onDelete('cascade');
            $table->foreignId('true_id')->nullable()->references('id')->on('true_questions')->onDelete('cascade');
            $table->foreignId('radio_id')->nullable()->references('id')->on('radio_questions')->onDelete('cascade');
            $table->foreignId('submission_id')->nullable()->references('id')->on('submission_forms')->onDelete('cascade');
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
        Schema::dropIfExists('questions_forms');
    }
}
