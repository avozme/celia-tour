<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeftAndTopToPortkeyScene extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portkey_scene', function (Blueprint $table) {
            $table->integer("top")->nullable($value = true)->default(null);
            $table->integer("left")->nullable($value = true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portkey_scene', function (Blueprint $table) {
            //
        });
    }
}
