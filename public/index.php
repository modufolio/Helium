<?php

use App\Core\App;


define("START_TIMER", microtime(true));

require_once dirname(__DIR__) .'/bootstrap.php';

exit((new App())->setRoutes()->run());
