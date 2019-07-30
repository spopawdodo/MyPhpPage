<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require('Config.php');
require ('Autoloader.php');
session_start();

// Controller Class
$controller = new MVC\Controllers\Controller();
$formController = new MVC\Controllers\FormController();
$fileController = new MVC\Controllers\FileController();

$router = new MVC\Routing\Routing();

$action = $_REQUEST['action'] ?? '';

$arr = $router->getAction($action);
$callable = $arr[1];

switch ($arr[0]){
    case 1:
        $controller->$callable();
        break;
    case 2:
        $fileController->$callable();
        break;
    case 3:
        $formController->$callable();
        break;
    default:
        echo ("Action unknown !");
        die();
        break;

}


var_dump($action);
var_dump($_SESSION);
var_dump($_REQUEST);


