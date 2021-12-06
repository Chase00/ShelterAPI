<?php

namespace Shelter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shelter\Models\Employee;
use Shelter\Validations\Validator;

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
        // Validate the request
        $validation = Validator::validateEmployee($request);

        // If validation failed
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

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
        // Validate the request
        $validation = Validator::validateEmployee($request);

        // If validation failed
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        // Validation has passed; Proceed to update the employee
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