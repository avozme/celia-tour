<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('file_image', 1000);
            $table->string('file_miniature', 1000);
            /*
            se usan ?
            $table->integer('top');
            $table->integer('left');
            */
            $table->integer("id_starting_points");
            $table->integer("id_starting_scenes");
            $table->foreign('id_starting_points')->references('id')->on('points');
            $table->foreign('id_starting_scenes')->references('id')->on('scenes');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            //$table->timestamps()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
}
