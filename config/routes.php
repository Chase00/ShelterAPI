<?php

use Shelter\Middleware\Logging as ChatterLogging;

$app->get('/', function ($request, $response, $args) {
    return $response->write('Shelter API default endpoint');
});

// Animal routes
$app->group('/animals', function () {
    $this->get('', 'AnimalController:index');
    $this->get('/{id}', 'AnimalController:view');
    $this->get('/{id}/customer', 'AnimalController:viewCustomer');
});

// Customer routes
$app->group('/customers', function () {
    $this->get('', 'CustomerController:index');
    $this->get('/{id}', 'CustomerController:view');
});

// Employee routes
$app->group('/employees', function () {
    $this->get('', 'EmployeeController:index');
    $this->get('/{id}', 'EmployeeController:view');

    $this->post('', 'EmployeeController:create');
    $this->put('/{id}', 'EmployeeController:update');
    $this->patch('/{id}', 'EmployeeController:update');
    $this->delete('/{id}', 'EmployeeController:delete');
});

// Position routes
$app->group('/positions', function () {
    $this->get('', 'PositionController:index');
    $this->get('/{id}', 'PositionController:view');
});

// Food routes
$app->group('/food', function () {
    $this->get('', 'FoodController:index');
    $this->get('/{id}', 'FoodController:view');
});

$app->add(new ChatterLogging());
$app->run();