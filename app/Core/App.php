<?php
namespace App\Core;

use Closure;

class App
{
    private static $instance;
    public array $routes = [];

    public function __construct()
    {

        $this->bootApp();
        self::instance($this);
    }

    public function bootApp(): void
    {
        error_reporting($this->debug() === true ? E_ALL : 0);
        ini_set('display_errors', $this->debug() === true ? '1' : '0');
        ini_set('display_startup_errors', $this->debug() === true ? '1' : '0');
        $this->setRoutes();
    }

    public function debug(): bool
    {
        return env('APP_DEBUG', false);
    }

    public function callClosure(Closure $action)
    {
        return $action->call($this);
    }

    public function callController($action)
    {
        [$class, $method] = $action;
        $controller = $this->instantiateController($class);
        return $controller->$method();
    }

    protected function instantiateController(string $class): object
    {
        return new $class();
    }

    public function headers(): array
    {
        return [
            'App' => Timer::app() . ' ms',
        ];
    }

    public static function instance(self $instance = null): App
    {
        if ($instance !== null) {
            return static::$instance = $instance;
        }

        return static::$instance ?? new static();
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
        if (is_a($input, '\App\Core\Response') === true) {
            return $input->send();
        }

        return (new Response('Not Found', null, 404))->send();
    }

    public function setRoutes(): self
    {
        $this->routes = include BASE_DIR . '/routes/web.php';
        return $this;
    }

    public function run(): string
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $uri_path = $uri === '/' ? '/' : substr(parse_url($uri, PHP_URL_PATH), 1);
        $action = $this->routes[$uri_path] ?? null;

        if(is_string($action)){
            return $this->Io($action);
        }

        if(is_a($action, 'Closure')){
            return $this->Io($this->callClosure($action));
        }
        if(is_array($action) && class_exists($action[0])){
            return $this->Io($this->callController($action));
        }

        return $this->Io(null);

    }

}
