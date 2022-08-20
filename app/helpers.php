<?php

use App\Response;

function getRequestTime(): string
{
    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    return 'Page generated:' .  sprintf('%s ms', number_format($time * 1000, 2));
}

function notFound(): Response
{
    return new Response('Not Found', null, 404);
}

