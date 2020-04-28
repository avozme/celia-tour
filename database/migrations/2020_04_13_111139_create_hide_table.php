<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hide', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('width', 8, 4)->default(0.0);
            $table->float('height', 8, 4)->default(0.0);
            $table->boolean('type')->default(true); //true será pregunta y false será pista
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hide');
    }
}
