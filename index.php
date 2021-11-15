<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap.php';

use Psr\Http\Animal\ServerRequestInterface as Request;
use Psr\Http\Animal\ResponseInterface as Response;
use Shelter\Models\Customer;
use Shelter\Models\Animal;
use Shelter\Models\Food;
use Shelter\Models\Employee;
use Shelter\Models\Position;

$app->get('/', function ($request, $response, $args) {
    return $response->write("Shelter API default endpoint");
});


// Return all animals
$app->get('/animals', function ($request, $response, array $args) {

    //Get the total number of animals
    $count = Animal::count();

    //Get querystring variable from url
    $params = $request->getQueryParams();

    // Do limit and offset exist?
    // Limiting the query to only return 10

    // 10 items per page
    $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;
    // offset of the first item
    $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;
// offset of the first item
//Get search terms
    $term = array_key_exists('q', $params) ? $params['q'] : null;
    if (!is_null($term)) {
        $Animals = Animal::searchAnimals($term);
        $payload_final = [];
        foreach ($Animals as $_a) {
            $payload_final[$_a->animal_ID] = [
                'animal_name' => $_a->animal_name,
                'animal_breed' => $_a->animal_breed,
                'animal_cost' => $_a->animal_cost,
                'adopted_boolean' => $_a->adopted_boolean,
                'animal_type' => $_a->animal_type,
                'customer_ID' => $_a->customer_ID
            ];
        }
    } else {
        //Pagination
        $links = Animal::getLinks($request, $limit, $offset);
// Sorting.
        $sort_key_array = Animal::getSortKeys($request);
        $query = Animal::with('customer');
//$query = Animal::all();
        $query = $query->skip($offset)->take($limit); // limit the rows
// sort the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }
        $Animals = $query->get();
        $payload = [];
        foreach ($Animals as $_a) {
            $payload[$_a->animal_ID] = [
                'animal_name' => $_a->animal_name,
                'animal_breed' => $_a->animal_breed,
                'animal_cost' => $_a->animal_cost,
                'adopted_boolean' => $_a->adopted_boolean,
                'animal_type' => $_a->animal_type,
                'customer_ID' => $_a->customer_ID
            ];
        }
        $payload_final = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $payload
        ];
    }
    return $response->withStatus(200)->withJson($payload_final);
});

// Return a specific animal by id
$app->get('/animals/{animal_ID}', function ($request, $response, array $args) {
    $id = $args['animal_ID'];
    $animal = new Animal();
    $_a = $animal->find($id);

    $payload[$_a->animal_ID] = [
        'animal_name' => $_a->animal_name,
        'animal_breed' => $_a->animal_breed,
        'animal_cost' => $_a->animal_cost,
        'adopted_boolean' => $_a->adopted_boolean,
        'animal_type' => $_a->animal_type,
        'customer_ID' => $_a->customer_ID
    ];
    return $response->withStatus(200)->withJson($payload);
});

// Return the customer who ahs adopted the animal (If applicable)
$app->get('/animals/{animal_ID}/customer', function ($request, $response, $args) {
    $id = $args['animal_ID'];
    $animal = new Animal();
    $customer = $animal->find($id)->customer;

    if ($customer !== null) {
        $payload[$customer->customer_ID] = [
            'customer_name' => $customer->customer_name,
            'customer_age' => $customer->customer_age,
            'customer_phone' => $customer->customer_phone,
        ];
        return $response->withStatus(200)->withJson($payload);
    } else {
        return $response->withStatus(200)->withJson(['This Animal has not been adopted']);
    }
});

// Return all customers
$app->get('/customers', function ($request, $response, array $args) {
    $customers = Customer::all();

    $payload = [];

    foreach ($customers as $_c) {
        $payload[$_c->customer_ID] = [
            'customer_name' => $_c->customer_name,
            'customer_age' => $_c->customer_age,
            'customer_phone' => $_c->customer_phone,

        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

// Return a specific customer by id
$app->get('/customers/{customer_ID}', function ($request, $response, array $args) {
    $id = $args['customer_ID'];
    $customer = new Customer();
    $_c = $customer->find($id);

    $payload[$_c->customer_ID] = [
        'customer_name' => $_c->customer_name,
        'customer_age' => $_c->customer_age,
        'customer_phone' => $_c->customer_phone,
    ];
    return $response->withStatus(200)->withJson($payload);
});

// Return all employees - /employees
$app->get('/employees', function ($request, $response, array $args) {
    $employees = Employee::all();

    $payload = [];

    foreach ($employees as $_e) {
        $payload[$_e->employee_ID] = [
            'employee_first_name' => $_e->employee_first_name,
            'employee_last_name' => $_e->employee_last_name,
            'employee_date_joined' => $_e->employee_date_joined,
            'position_ID' => $_e->position_ID,
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

// Return all employees by id - /employees/{employee_ID}
$app->get('/employees/{employee_ID}', function ($request, $response, array $args) {
    $id = $args['employee_ID'];
    $employee = new Employee();
    $_e = $employee->find($id);

    $payload[$_e->employee_ID] = [
        'employee_first_name' => $_e->employee_first_name,
        'employee_last_name' => $_e->employee_last_name,
        'employee_date_joined' => $_e->employee_date_joined,
        'position_ID' => $_e->position_ID,
    ];
    return $response->withStatus(200)->withJson($payload);
});

// Return all positions - /positions
$app->get('/positions', function ($request, $response, array $args) {
    $position = Position::all();

    $payload = [];

    foreach ($position as $_p) {
        $payload[$_p->position_ID] = [
            'position_title' => $_p->position_title,
            'position_salary' => $_p->position_salary,
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

// Return all positions by id - /positions/{position_ID}
$app->get('/positions/{position_ID}', function ($request, $response, array $args) {
    $id = $args['position_ID'];
    $position = new Position();
    $_p = $position->find($id);

    $payload[$_p->position_ID] = [
        'position_title' => $_p->position_title,
        'position_salary' => $_p->position_salary,
    ];
    return $response->withStatus(200)->withJson($payload);
});

// Return all animal food - /food
$app->get('/food', function ($request, $response, array $args) {
    $food = Food::all();

    $payload = [];

    foreach ($food as $_f) {
        $payload[$_f->animalFood_ID] = [
            'animalFood_type' => $_f->animalFood_type,
            'animalFood_description' => $_f->animalFood_description,
            'animalFood_price' => $_f->animalFood_price
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

// Return animal food by id - /food/{animalFood_ID}
$app->get('/food/{animalFood_ID}', function ($request, $response, array $args) {
    $id = $args['animalFood_ID'];
    $food = new Food();
    $_f = $food->find($id);

    $payload[$_f->animalFood_ID] = [
        'animalFood_type' => $_f->animalFood_type,
        'animalFood_description' => $_f->animalFood_description,
        'animalFood_price' => $_f->animalFood_price
    ];
    return $response->withStatus(200)->withJson($payload);
});


$app->run();