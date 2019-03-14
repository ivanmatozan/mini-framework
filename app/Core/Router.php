<?php

namespace App\Core;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;

/**
 * Class Router
 * @package App\Core
 */
class Router
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     */
    public function setPath(string $path = '/'): void
    {
        $this->path = $path;
    }

    /**
     * @param string $uri
     * @param callable $handler
     * @param array $methods
     */
    public function addRoute(string $uri, $handler, array $methods = ['GET']): void
    {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    /**
     * @return callable|array
     * @throws MethodNotAllowedException
     * @throws RouteNotFoundException
     */
    public function getResponse()
    {
        if (!isset($this->routes[$this->path])) {
            throw new RouteNotFoundException("No route registered for: {$this->path}");
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path], true)) {
            throw new MethodNotAllowedException();
        }

        return $this->routes[$this->path];
    }
}
