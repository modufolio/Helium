<?php

use App\App;
use App\Controllers\Controller;

require_once '../bootstrap.php';

$map = include '../app/routes/web.php';

$controller = new Controller();

echo App::run($map, $controller);
