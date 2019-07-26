<?php


namespace MVC\Controllers;
/*
use MVC\Controllers\FormController;
use MVC\Views\View;
use MVC\Models\Files;
use MVC\Models\User;
*/

class CheckController
{
    /// CHECKS & REDIRECTS

    // Checking the error array for new entries
    // Used in : changePasswordAction
    //           changeEmailAction
    //           deleteAccountAction

    public function checkForErrors(array $errorArray){
        if (!empty($errorArray)){
            var_dump($errorArray);
            return true;
        }
        return false;
    }

    // Checks for an active session
    public function isUserLoggedIn()
    {
        return
            isset($_SESSION['user'])
            && isset($_SESSION['id'])
            && $_SESSION['id'] > 0
            ;
    }

    public function isAdmin(){
        return $this->isUserLoggedIn()
            && $_SESSION['role'] == 'admin';
    }

    // Redirects to given location
    public function redirect(string $location)
    {
        header('Location: ' . $location);
        exit;
    }
}