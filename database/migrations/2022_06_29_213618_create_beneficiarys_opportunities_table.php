<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiarysOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiarys_opportunities', function (Blueprint $table) {
            $table->id();
            $table->text('answer')->nullable();
            $table->integer('degree')->nullable();
            $table->foreignId('survey_id')->nullable()->references('id')->on('surveys')->onDelete('cascade');
            $table->foreignId('opportunity_id')->nullable()->references('id')->on('opportunities')->onDelete('cascade');
            $table->foreignId('beneficiary_id')->nullable()->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('beneficiarys_opportunities');
    }
}
