<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJumpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('destination_pitch');
            $table->integer('destination_yaw');
            $table->integer('id_scene_destination');
            $table->integer('hotspot_id');
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
        Schema::dropIfExists('jumps');
    }
}
