<?php

namespace Shelter\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Shelter\Models\Food;

class FoodController
{
    //list all comments in database
    public function index(Request $request, Response $response, array $args){
        $results = Food::getFood();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get single comment by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Food::getFoodByID($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }
}