<?php

use App\App;
use App\Controllers\Controller;

// Turn off all error reporting
error_reporting(0);

require_once '../bootstrap.php';

$map = include '../app/routes/web.php';

$controller = new Controller();

echo App::run($map, $controller);
