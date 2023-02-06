<?php

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/app/Controllers/Controller.php';
require_once __DIR__ . '/app/App.php';
require_once __DIR__ . '/app/Response.php';

if (is_file($autoloader = __DIR__ . '/vendor/autoload.php')) {
    include $autoloader;
}
