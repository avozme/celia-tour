<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToEscaperooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('escape_rooms', function (Blueprint $table) {
            $table->bigInteger('start_scene')->nullable();
            $table->string('history', 3500)->default("");
            $table->bigInteger('id_audio')->nullable();
            $table->bigInteger('environment_audio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escaperooms', function (Blueprint $table) {
            //
        });
    }
}
