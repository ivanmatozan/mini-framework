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
    public function get(string $uri, callable $handler): void
    {
        $this->getRouter()->addRoute($uri, $handler);
    }

    /**
     * @param string $uri
     * @param callable $handler
     */
    public function post(string $uri, callable $handler): void
    {
        $this->getRouter()->addRoute($uri, $handler, ['POST']);
    }

    /**
     * @param string $uri
     * @param callable $handler
     * @param array $mehods
     */
    public function map(string $uri, callable $handler, array $mehods): void
    {
        $this->getRouter()->addRoute($uri, $handler, $mehods);
    }

    public function run(): void
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

        $response();
    }
}
