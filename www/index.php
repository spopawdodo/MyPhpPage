<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require ('MVC/Controller.php');
session_start();

// Controller Class
$controller = new Controller();

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'userLoggedIn':
        /*switch ($accountAction){
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
                $controller->uploadFiles();
                break;
            default: break;}*/
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
        $controller->uploadFiles();
        break;
    case 'downloadFile':
        $controller->downloadFile();
        break;
    case 'deleteFile':
        $controller->deleteFile();
        break;
    default:
        $controller->loginFormAction();
        break;
}

var_dump($action);
var_dump($_SESSION);
var_dump($_REQUEST);


