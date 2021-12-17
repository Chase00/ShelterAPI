<?php

namespace Shelter\Authentication;

use Shelter\Models\Employee;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class JWTAuthentication
{
    public function __invoke(Request $request, Response $response, $next)
    {
        // If the header named "Authorization" does not exist, display an error
       if (!$request->hasHeader('Authorization')) {
           $results = array('status' => 'Authorization header not available');
           return $response->withJson($results, 404, JSON_PRETTY_PRINT);
       }
       // If Authorization header exists, retrieve the header and the header value
       $auth = $request->getHeader('Authorization');

       /* The value of the authorization header consists of bear and
        * the key separated by a space.
        */
       $token = substr($auth[0], strpos($auth[0], ' ') + 1); // the key is the second part of the string after a space

       if (!Employee::validateJWT($token)) {
           $results = array("status" => "Authentication failed");
           return $response->withJson($results, 401, JSON_PRETTY_PRINT);
       }

       // An employee has been authenticated.
       $response = $next($request, $response);
       return $response;
  }
}