<?php


namespace Shelter\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Shelter\Models\Customer;

class CustomerController
{
    // List all customers in the database
    public function index(Request $request, Response $response, array $args){
        $results = Customer::getCustomers();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Get a single customer by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Customer::getCustomerById($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }
}