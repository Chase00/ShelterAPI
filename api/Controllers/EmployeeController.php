<?php

namespace Shelter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shelter\Models\Employee;
use Shelter\Validations\Validator;
use Shelter\Models\Token;

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

    // Validate an employee with username and password. It returns a Bearer token on success
    public function authBearer(Request $request, Response $response)
    {
        $params = $request->getParsedBody();
        $employee_username = $params['employee_username'];
        $employee_password = $params['employee_password'];
        $employee = Employee::authenticateUser($employee_username, $employee_password);
        if ($employee) {
            $status_code = 200;
            $token = Token::generateBearer($employee->id);
            $results = [
                'status' => 'login successful',
                'token' => $token
            ];
        } else {
            $status_code = 401;
            $results = [
                'status' => 'login failed'
            ];
        }
        return $response->withJson($results, $status_code,
            JSON_PRETTY_PRINT);
    }

    // Validate an employee with username and password. It returns a JWT token on success.
    public function authJWT(Request $request, Response $response)
    {
        $params = $request->getParsedBody();
        $username = $params['employee_username'];
        $password = $params['employee_password'];
        $employee = Employee::authenticateEmployee($username, $password);
        if ($employee) {
            $status_code = 200;
            $jwt = Employee::generateJWT($employee->id);
            $results = [
                'status' => 'login successful',
                'jwt' => $jwt,
                'name' => $employee->employee_username
            ];
        } else {
            $status_code = 401;
            $results = [
                'status' => 'login failed',
            ];
        }
        //return $results;
        return $response->withJson($results, $status_code,
            JSON_PRETTY_PRINT);
    }
}