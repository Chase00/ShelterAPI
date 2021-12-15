<?php

namespace Shelter\Authentication;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Shelter\Models\Employee;

class MyAuthenticator
{
    /*
     * Use the __invoke method so the object can be used as a callable
     * This method gets called automatically when the whole class is treated as callable.
    */
    public function __invoke(Request $request, Response $response, $next)
    {
        // If the header named "ShelterAPI-Authorization" does not exist display an error
        if (!$request->hasHeader('ShelterAPI-Authorization')) {
            $results = array('status' => 'Authorization header not available');
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        // ShelterAPI-Authorization header exists, retrieve the username and password from the header
        $auth = $request->getHeader('ShelterAPI-Authorization');
        list($employee_username, $employee_password) = explode(':', $auth[0]);

        // Validate the header value by calling Employee's authenticateUser method.
        if (!Employee::authenticateEmployee($employee_username, $employee_password)) {
            $results = array("status" => "Authentication failed");
            return $response->withJson($results, 401, JSON_PRETTY_PRINT);
        }

        // An employee has been authenticated.
        $response = $next($request, $response);
        return $response;
    }
}