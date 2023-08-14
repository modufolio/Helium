<?php

const BASE_DIR = __DIR__;

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/app/Core/App.php';
require_once __DIR__ . '/app/Core/Response.php';

if (is_file($autoloader = __DIR__ . '/vendor/autoload.php')) {
    include $autoloader;
}
