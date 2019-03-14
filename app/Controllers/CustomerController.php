<?php

namespace App\Controllers;

use PDO;
use App\Core\Response;
use App\Models\Customer;

/**
 * Class CustomerController
 * @package App\Controllers
 */
class CustomerController
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Customer constructor.
     * @param \PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param Response $response
     * @return Response
     */
    public function jsonList(Response $response): Response
    {
        $stmt = $this->db->query('SELECT * FROM customer');
        $customers = $stmt->fetchAll(PDO::FETCH_CLASS, Customer::class);

        return $response->withJson($customers);
    }
}
