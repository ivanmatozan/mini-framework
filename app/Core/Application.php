<?php

namespace App\Core;

/**
 * Class Application
 * @package App
 */
class Application
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->container = new Container([
            'router' => function () {
                return new Router();
            }
        ]);
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->getContainer()->router;
    }

    /**
     * @param string $uri
     * @param callable $handler
     */
    public function get(string $uri, $handler): void
    {
        $this->getRouter()->addRoute($uri, $handler);
    }

    /**
     * @param string $uri
     * @param callable $handler
     */
    public function post(string $uri, $handler): void
    {
        $this->getRouter()->addRoute($uri, $handler, ['POST']);
    }

    /**
     * @param string $uri
     * @param callable $handler
     * @param array $methods
     */
    public function map(string $uri, $handler, array $methods): void
    {
        $this->getRouter()->addRoute($uri, $handler, $methods);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $router = $this->getRouter();
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');

        try {
            $response = $router->getResponse();
        } catch (\App\Exceptions\RouteNotFoundException $e) {
            if ($this->container->has('errorHandler')) {
                $response = $this->container->errorHandler;
            } else {
                return;
            }
        } catch (\App\Exceptions\MethodNotAllowedException $e) {
            return;
        }

        return $this->process($response);
    }

    /**
     * @param callable|array $callable
     * @return mixed
     */
    protected function process($callable)
    {
        if (is_array($callable)) {
            if (!is_object($callable[0])) {
                $callable[0] = new $callable[0];
            }
            return call_user_func($callable);
        }

        return $callable();
    }
}
