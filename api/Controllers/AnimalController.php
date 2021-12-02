<?php


namespace Shelter\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Shelter\Models\Animal;

class AnimalController
{

    // List all animals with pagination, sort, search by query features
    public function index(Request $request, Response $response, array $args)
    {
        $results = Animal::getAnimals($request);
        $code = array_key_exists("status", $results) ? 500 : 200;

        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // View an animal by id
    public function view(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $results = Animal::getAnimalById($id);
        $code = array_key_exists("status", $results) ? 500 : 200;

        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // View the customer who adopted the animal
    public function viewComments(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $results = Animal::getCustomerByAnimal($id);
        $code = array_key_exists("status", $results) ? 500 : 200;

        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }
}