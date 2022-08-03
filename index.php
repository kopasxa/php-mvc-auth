<?php

require './core/controller.php';
require './core/model.php';
require './core/view.php';

session_start();

$controller_name = 'Login';
$action_name = 'index';

$routes = explode('/', $_SERVER['REQUEST_URI']);

if (!empty($routes[1])) {
    $controller_name = $routes[1];
}

if (!empty($routes[2])) {
    $action_name = $routes[2];
}

$model_name = 'Model_' . $controller_name;
$controller_name = 'Controller_' . $controller_name;
$action_name = 'action_' . $action_name;


/* echo "Model: $model_name <br>";
echo "Controller: $controller_name <br>";
echo "Action: $action_name <br>"; */


$model_file = strtolower($model_name) . '.php';
$model_path = "./models/" . $model_file;
if (file_exists($model_path)) {
    include "./models/" . $model_file;
}


$controller_file = strtolower($controller_name) . '.php';
$controller_path = "./controllers/" . $controller_file;
if (file_exists($controller_path)) {
    include "./controllers/" . $controller_file;
}


$controller = new $controller_name;
$action = $action_name;

if (method_exists($controller, $action)) {
    $controller->$action();
}
