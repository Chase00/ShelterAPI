<?php

// Alias to the controllers
use Shelter\Controllers\AnimalController as AnimalController;
use Shelter\Controllers\CustomerController as CustomerController;
use Shelter\Controllers\EmployeeController as EmployeeController;
use Shelter\Controllers\PositionController as PositionController;
use Shelter\Controllers\FoodController as FoodController;

/*
 * The following is the controller and middleware factory. It
 * registers controllers and middleware with the DI container so
 * they can be accessed in other classes. Injecting instances into
 * the DI container so you don't need to pass the entire container or app,
 * rather only the services needed.
 * https://akrabat.com/accessing-services-in-slim-3/#comment-35429
 */

// Register controllers with the DIC. $c is the container itself.
$container['AnimalController'] = function ($c) {
    return new AnimalController();
};

$container['CustomerController'] = function ($c) {
    return new CustomerController();
};

$container['EmployeeController'] = function ($c) {
    return new EmployeeController();
};

$container['PositionController'] = function ($c) {
    return new PositionController();
};

$container['FoodController'] = function ($c) {
    return new FoodController();
};

