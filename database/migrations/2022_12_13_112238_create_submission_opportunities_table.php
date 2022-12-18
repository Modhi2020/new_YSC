<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->nullable()->references('id')->on('submission_forms')->onDelete('cascade');
            $table->foreignId('opportunity_id')->nullable()->references('id')->on('opportunities')->onDelete('cascade');
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
        Schema::dropIfExists('submission_opportunities');
    }
}
