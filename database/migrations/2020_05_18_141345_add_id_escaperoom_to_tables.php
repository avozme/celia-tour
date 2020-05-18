<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdEscaperoomToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->bigInteger('id_escaperoom')->default(1);
        });
        Schema::table('clues', function (Blueprint $table) {
            $table->bigInteger('id_escaperoom')->default(1);
        });
        Schema::table('keys', function (Blueprint $table) {
            $table->bigInteger('id_escaperoom')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
}
