<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
<<<<<<< HEAD
            $table->timestamps()->useCurrent();
            $table->integer("id_gallery");
            $table->integer("id_resources");
=======
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            //$table->timestamps()->useCurrent();
>>>>>>> 2019013e4a3363d5d83a1d1e026cfbe7d5732c95
            $table->foreign("id_gallery")->references("id")->on("gallery");
            $table->foreign("id_resources")->references("id")->on("resources");
            $table->integer("order");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_gallery');
    }
}
