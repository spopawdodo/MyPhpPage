<?php


namespace MVC\Controllers;

use MVC\Views\View;
use MVC\Controllers\CheckController;

/*
use MVC\Models\Files;
use MVC\Models\User;
*/

class FormController
{
    private $checkController;
    private $view;
    public function __construct()
    {
        $this->checkController = new CheckController();
        $this->view = new View();
    }

    public function loginFormAction(){

        if ($this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php?action=userLoggedIn');
        }

        return $this->view->display('Login');
    }

    public function signUpFormAction(){

        if ($this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php?action=userLoggedIn');
        }

        return $this->view->display('SignUp');
    }

    public function changePasswordFormAction(){
        if (!$this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php');
        }
        $this->view->display('PasswordSettings', true);
    }

    public function changeEmailFormAction(){
        if (!$this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php');
        }
        $this->view->display('EmailSettings', true);
    }

    public function deleteAccountFormAction(){
        if (!$this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php');
        }
        $this->view->display('deleteAccount',true);
    }

}