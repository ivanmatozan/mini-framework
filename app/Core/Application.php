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
        $this->container = new Container();
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
