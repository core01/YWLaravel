<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('city_id');
            $table->integer('date');
            $table->string('part');
            $table->integer('temp_min');
            $table->integer('temp_max');
            $table->integer('temp_avg');
            $table->integer('feels_like');
            $table->string('condition');
            $table->string('daytime');
            $table->float('wind_speed');
            $table->float('wind_gust');
            $table->string('wind_dir');
            $table->integer('pressure_mm');
            $table->integer('pressure_pa');
            $table->integer('humidity');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecasts');
    }
}
