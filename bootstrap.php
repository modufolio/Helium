<?php

require_once __DIR__ . '/app/helpers.php';
if (is_file($autoloader = __DIR__ . '/vendor/autoload.php')) {
    include $autoloader;
} else {
    require_once __DIR__ . '/app/controllers/Controller.php';
    require_once __DIR__ . '/app/App.php';
    require_once __DIR__ . '/app/Response.php';
}