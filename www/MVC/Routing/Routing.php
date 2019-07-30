<?php

namespace MVC\Routing;

class Routing
{
    /***
     * @param string $action
     * @return array
     * 1 -> controller action
     * 2 -> files controller action
     * 3 -> form controller action
     */
    public function getAction(string $action):array {
     if ($action == 'userLoggedIn')
         return [1, 'loggedInFormAction'];

     if ($action == 'authenticate')
         return [1, 'authenticateUserAction'];

     if ($action == 'createAccount')
         return [1, 'signUpUserAction'];

     if ($action == 'logout')
         return [1, 'logoutUserAction'];

     if ($action == 'changePassword')
         return [1, 'changePasswordAction'];

     if ($action == 'changeEmail')
         return [1, 'changeEmailAction'];

     if ($action == 'deleteAccount')
         return [1, 'deleteAccountAction'];

     if ($action == 'uploadFiles')
         return [2, 'uploadFiles'];

     if ($action == 'downloadFile')
         return [2, 'downloadFile'];

     if ($action == 'deleteFile')
         return [2 ,'deleteFile'];

     if ( $action == 'adminPage')
         return [1, 'loggedInFormAction'];

     if ( $action == 'deleteUserAccount')
         return [1, 'deleteUserAccount'];

     return [3, 'loginFormAction'];
    }
}