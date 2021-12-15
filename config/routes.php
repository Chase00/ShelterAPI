<?php

use Shelter\Middleware\Logging as ShelterLogging;
use Shelter\Authentication\MyAuthenticator;
use Shelter\Authentication\BasicAuthenticator;
use Shelter\Authentication\BearerAuthenticator;
use Shelter\Authentication\JWTAuthentication;

$app->get('/', function ($request, $response, $args) {
    return $response->write('Shelter API default endpoint');
});

// Employee routes
$app->group('/employees', function () {
    $this->get('', 'EmployeeController:index');
    $this->get('/{id}', 'EmployeeController:view');
    $this->post('', 'EmployeeController:create');
    $this->put('/{id}', 'EmployeeController:update');
    $this->patch('/{id}', 'EmployeeController:update');
    $this->delete('/{id}', 'EmployeeController:delete');

    // Authentication token routes
    $this->post('/authBearer', 'EmployeeController:authBearer');
    $this->post('/authJWT', 'EmployeeController:authJWT');
});

// Route groups
$app->group('', function () {

    // Animal routes
    $this->group('/animals', function () {
        $this->get('', 'AnimalController:index');
        $this->get('/{id}', 'AnimalController:view');
        $this->get('/{id}/customer', 'AnimalController:viewCustomer');
    });

    // Customer routes
    $this->group('/customers', function () {
        $this->get('', 'CustomerController:index');
        $this->get('/{id}', 'CustomerController:view');
    });

    // Position routes
    $this->group('/positions', function () {
        $this->get('', 'PositionController:index');
        $this->get('/{id}', 'PositionController:view');
    });

    // Food routes
    $this->group('/food', function () {
        $this->get('', 'FoodController:index');
        $this->get('/{id}', 'FoodController:view');
    });
});
//})->add(new JWTAuthentication());

//$app->add(new BasicAuthenticator());
//$app->add(new BearerAuthenticator());
//$app->add(new JWTAuthentication());

$app->add(new ShelterLogging());
$app->run();