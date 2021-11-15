<?php

//include __DIR__ . '/config/credentials.php';
//include __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/config/credentials.php';
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$capsule = new Capsule();
$capsule -> addConnection([
    "driver" => "mysql",
    "host" => $db_host,
//    "port" => 3306,
    "database" => $db_name,
    "username" => $db_user,
    "password" => $db_pass,
    "charset" => "utf8",
    "collation" => "utf8_general_ci",
    "prefix" => "" // Optional
]);

$capsule -> setAsGlobal();
$capsule -> bootEloquent();

$container = $app -> getContainer();
$container['db'] = function($container)use($capsule){
    return $capsule;
};