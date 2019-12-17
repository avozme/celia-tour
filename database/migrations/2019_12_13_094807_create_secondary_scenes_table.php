<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondaryScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_scenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps()->useCurrent();
            $table->string("name");
            $table->date("date");
            $table->integer("pitch");
            $table->integer("yaw");
            $table->string("directory_name");
            $table->foreign("id_scenes")->references("id")->on("scenes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secondary_scenes');
    }
}
