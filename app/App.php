<?php
namespace App;

class App
{
    public static function run($map, $class): string
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $uri_path = parse_url($uri, PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        $search = empty($uri_segments[1]) ? $uri : $uri_segments[1];

        $action = $map[$search] ?? notFound();

        if(is_a($action, 'Closure')){
            return self::Io($action());
        }
        $actions = get_class_methods($class);
        $actionController = strtolower($_SERVER['REQUEST_METHOD']) . ucfirst($action);

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
