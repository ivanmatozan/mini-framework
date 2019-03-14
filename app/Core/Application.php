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
            },
            'response' => function () {
                return new Response();
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
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->getContainer()->response;
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
     * @return void
     */
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

        $this->respond($this->process($response));
    }

    /**
     * @param callable|array $callable
     * @return mixed
     */
    protected function process($callable)
    {
        if (is_array($callable) && !is_object($callable[0])) {
            $callable[0] = new $callable[0];
        }

        return $callable($this->getResponse());
    }

    /**
     * @param Response|string $response
     */
    protected function respond($response): void
    {
        if (!$response instanceof Response) {
            echo $response;
            return;
        }

        http_response_code($response->getStatusCode());

        foreach ($response->getHeaders() as $name => $value) {
            header(sprintf('%s: %s', $name, $value));
        }

        echo $response->getBody();
    }
}
