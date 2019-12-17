<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSceneGuidedVisitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scenes_guided_visit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->integer("id_resources");
            $table->integer("id_scenes");
            $table->integer("id_guided_visit");
            $table->string('file_preview', 1000);
            $table->foreign('id_resources')->references('id')->on('resources');
            $table->foreign('id_scenes')->references('id')->on('scenes');
            $table->foreign('id_guided_visit')->references('id')->on('guided_visits');
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
        Schema::dropIfExists('scenes_guided_visit');
    }
}
