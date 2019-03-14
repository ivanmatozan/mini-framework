<?php

namespace App\Controllers;

use App\Core\Response;

/**
 * Class User
 * @package App\Controllers
 */
class User
{
    /**
     * @param Response $response
     * @return mixed
     */
    public function json(Response $response)
    {
        return $response->withJson('test');
    }
}
