<?php

namespace Shelter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shelter\Models\Position;

class PositionController
{
    // List all positions in database
    public function index(Request $request, Response $response, array $args){
        $results = Position::getPositions();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Get single position by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Position::getPositionByID($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }
}