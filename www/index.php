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


$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'userLoggedIn':
        $controller->loggedInFormAction();
        break;
    case 'authenticate':
        $controller->authenticateUserAction();
        break;
    case 'createAccount':
        $controller->signUpUserAction();
        break;
    case 'logout':
        $controller->logoutUserAction();
        break;
    case 'changePassword':
        $controller->changePasswordAction();
        break;
    case 'changeEmail':
        $controller->changeEmailAction();
        break;
    case 'deleteAccount':
        $controller->deleteAccountAction();
        break;
    case 'uploadFiles':
        $fileController->uploadFiles();
        break;
    case 'downloadFile':
        $fileController->downloadFile();
        break;
    case 'deleteFile':
        $fileController->deleteFile();
        break;
    case 'adminPage':
        $controller->loggedInFormAction();
        break;
    case 'deleteUserAccount':
        $controller->deleteUserAccount();
        break;
    default:
        $formController->loginFormAction();
        break;
}

var_dump($action);
var_dump($_SESSION);
var_dump($_REQUEST);


