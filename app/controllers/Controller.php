<?php

namespace App\Controllers;

class Controller
{
    public function getHomepage(): string
    {
        return 'homepage';
    }

    public function getApi(): string
    {
        return getRequestTime();
    }

    public function postApi(): string
    {
        return getRequestTime();
    }

}