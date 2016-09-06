<?php
    /**
     * Project YWLaravel
     * Created by PhpStorm.
     * Author: core01
     * Date: 05.09.16
     */

    function isActiveRoute($route, $output = "active")
    {
        if (Route::currentRouteName() == $route) return $output;
    }