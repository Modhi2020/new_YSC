<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForeignkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('outcomings', function(Blueprint $table) {
			$table->foreign('incoming_id')->nullable()->references('id')->on('incomings')
						->onDelete('cascade');
		});

        Schema::table('incomings', function(Blueprint $table) {
			$table->foreign('outcoming_id')->nullable()->references('id')->on('outcomings')
						->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outcomings', function(Blueprint $table) {
			$table->dropForeign('outcomings_incoming_id_foreign');
		});

        Schema::table('incomings', function(Blueprint $table) {
			$table->dropForeign('incomings_outcoming_id_foreign');
		});
    }
}
