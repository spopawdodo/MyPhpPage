<?php


namespace MVC\Controllers;

use MVC\Views\View;
use MVC\Models\Files;
use MVC\Models\User;

class Controller{
    // to modify a lot private $model;
    private $modelFiles;
    private $modelUsers;
    private $checkController;
    private $formController;
    private $fileController;
    private $view;

    function __construct()
    {
        $this->modelFiles = new Files();
        $this->modelUsers = new User();
        $this->checkController = new CheckController();
        $this->formController = new FormController();
        $this->fileController = new FileController();
        $this->view = new View();
    }

    //Forms

    public function loggedInFormAction(){
        if (!$this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php');
        }
        else if ($this->checkController->isAdmin()){
            $this->view->display('AdminPage', true);
            $this->displayAllUsers();
            $this->displayAllFiles();
        } else {
            $this->view->display('UserPage', true);
            $this->fileController->displayFiles($_SESSION['id']);
        }
    }

    ///Login/Logout Actions

    //Checks for active session
    //Logs in & Starts Session
    //Redirects to UserPage
    //Authenticates both user and admin
    public function authenticateUserAction(){
        if ($this->checkController->isUserLoggedIn()) {
            $this->checkController->redirect('index.php?action=userLoggedIn');
        }
        $user = $_REQUEST['user']??'';
        $password = $_REQUEST['password']??'';

        $page = $this->modelUsers->getLogin($user, $password);
        if ($page == true) {
            $_SESSION['user'] = $user;
            $id = $this->modelUsers->getUserId($_SESSION['user']);
            $privilege = $this->modelUsers->getPrivilege($user);
            if ($id > 0)
                $_SESSION['id'] = $id;
            else
                $_SESSION['id'] = 0;
            $_SESSION['role'] = $privilege;

            if ($privilege == 'admin'){
                $this->checkController->redirect('index.php?action=adminPage');
            }else if ($privilege == 'user'){
                $this->checkController->redirect('index.php?action=userLoggedIn');
            } else {
                echo ("User type not set");
                return $this->formController->loginFormAction();
            }
        }
        else{
            return $this->formController->loginFormAction();

        }
    }

    //Unset & Destroy Session
    //Redirects to login page
    public function logoutUserAction(){
        session_unset();
        session_destroy();
        $this->checkController->redirect('index.php');
    }

    ///SignUp Action

    //Checks if the new user is valid
    //Creates account & (if ok) Return to User Page
    //Uses header
    public function signUpUserAction(){
        if (!empty($_REQUEST['newUser']) && !empty($_REQUEST['email']) && !empty($_REQUEST['password1']) && !empty($_REQUEST['password2'])){
            if($_REQUEST['password1'] == $_REQUEST['password2']){
                $user = $_REQUEST['newUser'];
                $password = $_REQUEST['password1'];
                $email = $_REQUEST['email'];
                $isFree = $this->modelUsers->checkUser($user, $email);
                if ($isFree != 0){
                    echo "Username taken !";
                    return $this->formController->signUpFormAction();
                }
                $accountCreated = $this->modelUsers->createAccount($user, $password, $email);
                if (!$accountCreated){
                    echo "Database Error !";
                    return  $this->formController->signUpFormAction();
                }
                else{
                    $_SESSION['user'] = $user;
                    $_SESSION['id'] = $this->modelUsers->getUserId($_SESSION['user']);
                    $_SESSION['role'] = 'user';
                    header('Location: index.php?action=userLoggedIn');
                    exit;
                }
            }else{
                echo "Passwords must be identical !";
                return  $this->formController->signUpFormAction();
            }
        }else{

            if (isset($_REQUEST['newUser']) && isset($_REQUEST['email']) && isset($_REQUEST['password1']) && isset($_REQUEST['password2']))
                echo "Empty fields !";
            return $this->formController->signUpFormAction();
        }

    }

    ///Account Settings Action

    //Checks if the new password is valid
    //Changes The Password & Return to LoginPage
    //Uses Header
    public function changePasswordAction(){
        $errorArray = [];
        //No empty fields

        if(empty($_REQUEST['password1'])) array_push($errorArray, 'Old password required!');
        if(empty($_REQUEST['newPassword1'])) array_push($errorArray, 'New password required!');
        if(empty($_REQUEST['newPassword2'])) array_push($errorArray, 'Confirm new password required!');

        if($this->checkController->checkForErrors($errorArray))
            return $this->formController->changePasswordFormAction();

        //Both new password must be identical

        $user = $_SESSION['user'];
        $oldPassword = $_REQUEST['password1'];
        $newPassword1 = $_REQUEST['newPassword1'];
        $newPassword2 = $_REQUEST['newPassword2'];

        if ($newPassword2 !=  $newPassword1){
            array_push($errorArray, 'Confirm new password!');
        } else{
            if($oldPassword == $newPassword1)
                array_push($errorArray, "Password must differ!");
        }

        if($this->checkController->checkForErrors($errorArray))
            return $this->formController->changePasswordFormAction();

        //Check old password
        $oldPasswordIsOk = $this->modelUsers->checkPassword($user, $oldPassword);
        if (!$oldPasswordIsOk){
            array_push($errorArray, 'Old Password is not correct');
        }else{
            //Change password
            $setPassword = $this->modelUsers->changePassword($user, $newPassword1);
            if ($setPassword){
                //return $this->logoutUserAction();
                header('Location: index.php?action=logout');
                exit;
            }
            else{
                echo "Database error";
                return $this->formController->changePasswordFormAction();            }
        }

        if($this->checkController->checkForErrors($errorArray))
            return $this->formController->changePasswordFormAction();
    }

    //Checks if the new email is not taken
    //Changes the email address & Returns to LoginPage
    //Uses Header
    public function changeEmailAction(){
        $errorArray = [];
        //No empty fields

        if(empty($_REQUEST['email'])) array_push($errorArray, 'Old email required!');
        if(empty($_REQUEST['newEmail'])) array_push($errorArray, 'New email required!');

        if($this->checkController->checkForErrors($errorArray))
            return $this->formController->changeEmailFormAction();

        $user = $_SESSION['user'];
        $email = $_REQUEST['email'];
        $newEmail = $_REQUEST['newEmail'];

        //Email addresses must be different

        if($email == $newEmail)
            array_push($errorArray, "Email addresses must differ!");


        if($this->checkController->checkForErrors($errorArray))
            return $this->formController->changeEmailFormAction();


        //Check old email
        $isUsed = $this->modelUsers->checkUser($user, $email);
        $isValid = $this->modelUsers->checkEmail($newEmail);
        if ($isUsed != 1){
            array_push($errorArray, 'Old email is not correct !');
        }
        if ($isValid != 0) {
            array_push($errorArray, 'Email address is taken !');
        }

        if($this->checkController->checkForErrors($errorArray))
            return $this->formController->changeEmailFormAction();


        //Change email
        $setEmail = $this->modelUsers->changeEmail($user, $newEmail);
        if ($setEmail){
            return $this->checkController->redirect('index.php?action=logout');
        }
        else{
            echo "Database error";
            return $this->formController->changeEmailFormAction();
        }
    }

    // Checks if the password is correct
    // Deletes the user data from the database
    // Redirects to Login Page
    public function deleteAccountAction(){
        $errorArray = [];
        $userName = $_SESSION['user'];
        $userId = $_SESSION['id'];
        //password field must be complete
        if (empty($_REQUEST['password1'])) array_push($errorArray, 'Password Required');
        if  ($this->checkController->checkForErrors($errorArray)){
            return $this->formController->deleteAccountFormAction();
        }
        //password must be correct
        $password = $_REQUEST['password1'];
        $isCorrect = $this->modelUsers->checkPassword($userName, $password);
        if (!$isCorrect) array_push($errorArray, 'Password is not correct!');
        if  ($this->checkController->checkForErrors($errorArray)){
            return $this->formController->deleteAccountFormAction();
        }

        //password is correct

        $isDeleted = $this->modelUsers->deleteAccount($userId);
        $userFiles = $this->modelFiles->getUserFiles($userId);
        if ($isDeleted){
            foreach($userFiles as $key=>$value){
                $this->fileController->removeFile($value['Image']);
            }
            $this->checkController->redirect('index.php?action=logout');
        }else{
            echo "Database error!";
            return $this->formController->deleteAccountFormAction();
        }
    }



    ///ADMIN ACTIONS

    //Displays all the users' files
    //Calls the displayFiles function for each user
    public function displayAllFiles(){
        $allFiles = $this->modelFiles->getAllFiles();

        foreach ($allFiles as $key=>$value){
            $this->fileController->displayFiles($value['UserId']);
        }
    }

    public function displayAllUsers(){
        $users = $this->modelUsers->getAllUsers();

        $this->view->set('User',$users);
        $this->view->display('AllUsers', true, false);

    }

    public function deleteUserAccount(){
        if (!$this->checkController->isAdmin()){
            echo ("You cannot use this function as a user");
            die();
        }
        $userId = $_REQUEST['userId'];

        $isDeleted = $this->modelUsers->deleteAccount($userId);
        $userFiles = $this->modelFiles->getUserFiles($userId);
        if ($isDeleted){
            foreach($userFiles as $key=>$value){
                $this->fileController->removeFile($value['Image']);
            }
            $this->checkController->redirect('index.php');
        }else{
            echo "Database error!";
            return $this->checkController->redirect('index.php');
        }
    }

    /// FILES ACTIONS

}
