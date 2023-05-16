<?php

use App\App;
use App\Controllers\Controller;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("START_TIMER", microtime(true));

require_once '../bootstrap.php';

$routes = include '../routes/web.php';

$controller = new Controller();

echo (new App())->run($routes, $controller);
