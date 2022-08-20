<?php
namespace App;

class App
{
    public static function run($map, $class): string
    {
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        $search = $uri_segments ? $uri_segments[1] : $uri_path;
        $actions = get_class_methods($class);

        if(!isset($map[$search])){
            return notFound();
        }

        $actionController = strtolower($_SERVER['REQUEST_METHOD']) . ucfirst($map[$search]);

        if (!in_array($actionController, $actions)) {
            return notFound();
        }

        return self::Io($class->$actionController());

    }

    public static function Io($input): string
    {

        // Simple HTML response
        if (is_string($input) === true) {
            return (new Response($input))->send();
        }

        // array to json conversion
        if (is_array($input) === true) {
            return (new Response($input))->json($input)->send();
        }

        // Response Configuration
        if (is_a($input, '\App\Response') === true) {
            return $input->send();
        }

        return '';
    }
}








