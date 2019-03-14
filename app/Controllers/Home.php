<?php

namespace App\Controllers;

use App\Core\Response;

/**
 * Class Home
 * @package App\Controllers
 */
class Home
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
