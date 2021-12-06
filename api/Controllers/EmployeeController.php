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

    // Create an employee when the employee signs up an account
    public function create(Request $request, Response $response, array $args)
    {

        // Validation has passed; Proceed to create the employee
        $employee = Employee::createEmployee($request);
        $results = [
            'status' => 'employee created',
            'data' => $employee
        ];
        $code = array_key_exists('status', $results) ? 201 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Update an employee
    public function update(Request $request, Response $response, array $args)
    {

        $employee = Employee::updateEmployee($request);
        $results = [
            'status' => 'employee updated',
            'data' => $employee
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Delete an employee
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        Employee::deleteEmployee($id);
        $results = [
            'status' => 'employee deleted',
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}