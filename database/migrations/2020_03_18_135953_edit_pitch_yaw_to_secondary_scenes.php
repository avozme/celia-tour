<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditPitchYawToSecondaryScenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secondary_scenes', function (Blueprint $table) {
            $table->float('pitch',5,4)->change();
            $table->float('yaw',5,4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('secondary_scenes', function (Blueprint $table) {
            //
        });
    }
}
