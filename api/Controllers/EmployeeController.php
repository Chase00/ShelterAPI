<?php

namespace Shelter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shelter\Models\Employee;

class EmployeeController
{
    // List all employees in the database
    public function index(Request $request, Response $response, array $args){
        $results = Employee::getEmployees();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Get a single employee by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Employee::getEmployeeById($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }
}