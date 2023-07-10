<?php
namespace App;

class App
{
    private static $instance;

    public function __construct()
    {
        self::instance($this);
    }

    public static function instance(self $instance = null): App
    {
        if ($instance !== null) {
            return static::$instance = $instance;
        }

        return static::$instance ?? new static();
    }

    public function run(array $routes, $class): string
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $uri_path = $uri === '/' ? '/' : substr(parse_url($uri, PHP_URL_PATH), 1);
        $action = $routes[$uri_path] ?? notFound();

        if(is_a($action, 'Closure')){
            return $this->Io($action->call($this));
        }
        $actions = get_class_methods($class);
        $actionController = strtolower($_SERVER['REQUEST_METHOD']) . ucfirst($action);

        if (!in_array($actionController, $actions)) {
            return notFound();
        }

        return $this->Io($class->$actionController());
    }

    public function Io($input): string
    {

        // Simple HTML response
        if (is_string($input) === true) {
            return (new Response($input,'text/html',200, $this->headers()))->send();
        }

        // array to json conversion
        if (is_array($input) === true) {
            return (new Response($input))->json($input, null,200, $this->headers())->send();
        }

        // Response Configuration
        if (is_a($input, '\App\Response') === true) {
            return $input->send();
        }

        return '';
    }

    public function headers(): array
    {
        return [
            'App' => Timer::app() . ' ms',
        ];
    }
}
