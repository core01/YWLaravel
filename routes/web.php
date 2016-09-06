<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | This file is where you may define all of the routes that are handled
    | by your application. Just tell Laravel the URIs it should respond
    | to using a Closure or controller method. Build something great!
    |
    */

    Route::get('/', function () {
        return view('main');
    })->name('main');

    Route::get('/parseWeather', [
        'uses' => 'YandexWeather@parseWeather',
        'as'   => 'parser',
    ]);
    Route::get('/weather', [
        'uses' => 'YandexWeather@getWeather',
        'as'   => 'weather',
    ]);
