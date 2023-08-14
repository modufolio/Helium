<?php

use App\Core\App;

if (!function_exists('app')) {
    function app(): object
    {
        return App::instance();
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        static $loaded = [];

        if (empty($loaded)) {
            $loaded = parse_ini_file(  '.env', false, INI_SCANNER_RAW);
            foreach ($loaded as &$value) {
                $value = trim($value);
                $value = in_array($value, ['true', 'false']) ? ($value === 'true') : $value;
            }
        }

        return $_ENV[$key] ?? $_SERVER[$key] ?? $loaded[$key] ?? $default;
    }
}



