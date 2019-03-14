<?php

namespace App\Controllers;

use App\Core\Response;

/**
 * Class HomeController
 * @package App\Controllers
 */
class HomeController
{
    /**
     * @param Response $response
     * @return Response
     */
    public function index(Response $response): Response
    {
        return $response->setBody('Index');
    }
}
