<?php

namespace App\Controllers;

class Controller
{

    public function getApi(): string
    {
        return getRequestTime();
    }

    public function postApi(): string
    {
        return getRequestTime();
    }

}