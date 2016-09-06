<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('city_id')->unique();
            $table->string('name');
            $table->string('country');
            $table->string('condition');
            $table->float('wind_speed');
            $table->float('wind_gust');
            $table->string('wind_dir');
            $table->integer('temp');
            $table->integer('feels_like');
            $table->integer('pressure_mm');
            $table->integer('pressure_pa');
            $table->integer('humidity');
            $table->string('daytime');
            $table->integer('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facts');
    }
}
