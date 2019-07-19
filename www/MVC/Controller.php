<?php

require_once ('Models.php');
require ('View.php');

class Controller{
    private $model;
    private $view;
    function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

    //Forms
    public function loginFormAction(){

        if ($this->isUserLoggedIn()) {
            $this->redirect('index.php?action=userLoggedIn');
        }

        return $this->view->display('Login');
    }

    public function signUpFormAction(){

        if ($this->isUserLoggedIn()) {
            $this->redirect('index.php?action=userLoggedIn');
        }

        return $this->view->display('SignUp');
    }

    public function loggedInFormAction(){
        if (!$this->isUserLoggedIn()) {
            $this->redirect('index.php');
        }
        $this->view->display('UserPage');
        $this->displayUserFiles();
    }

    public function changePasswordFormAction(){
        if (!$this->isUserLoggedIn()) {
            $this->redirect('index.php');
        }
        $this->view->display('PasswordSettings');
    }

    public function changeEmailFormAction(){
        if (!$this->isUserLoggedIn()) {
            $this->redirect('index.php');
        }
        $this->view->display('EmailSettings');
    }

    public function deleteAccountFormAction(){
        if (!$this->isUserLoggedIn()) {
            $this->redirect('index.php');
        }
        $this->view->display('deleteAccount');
    }

    ///Login/Logout Actions

    //Checks for active session
    //Logs in & Starts Session
    //Redirects to UserPage
    public function authenticateUserAction(){

        if ($this->isUserLoggedIn()) {
            $this->redirect('index.php?action=userLoggedIn');
        }

        $page = $this->model->getLogin();
        if ($page == "UserPage") {
            $_SESSION['user'] = $_REQUEST['user'];
            $id = $this->model->getUserId();
            if ($id > 0)
                $_SESSION['id'] = $id;
            else
                $_SESSION['id'] = 0;
            //return $this->loggedInFormAction();
            $this->redirect('index.php');
        }
        else{
            return $this->loginFormAction();

        }
    }

    //Unset & Destroy Session
    //Redirects to login page
    public function logoutUserAction(){
        session_unset();
        session_destroy();
        $this->redirect('index.php');
    }

    ///SignUp Action

    //Checks if the new user is valid
    //Creates account & (if ok) Return to User Page
    //Uses header
    public function signUpUserAction(){
        if (!empty($_REQUEST['newUser']) && !empty($_REQUEST['email']) && !empty($_REQUEST['password1']) && !empty($_REQUEST['password2'])){
            if($_REQUEST['password1'] == $_REQUEST['password2']){
                $isFree = $this->model->checkUser();
                if ($isFree != 0){
                    echo "Username taken !";
                    return $this->signUpFormAction();
                }
                $accountCreated = $this->model->createAccount();
                if (!$accountCreated){
                    echo "Database Error !";
                    return  $this->signUpFormAction();
                }
                else{
                    $_SESSION['user'] = $_REQUEST['newUser'];
                    $_SESSION['id'] = $this->model->getUserId();
                    header('Location: index.php?action=userLoggedIn');
                    exit;
                }
            }else{
                echo "Passwords must be identical !";
                return  $this->signUpFormAction();
            }
        }else{

            if (isset($_REQUEST['newUser']) && isset($_REQUEST['email']) && isset($_REQUEST['password1']) && isset($_REQUEST['password2']))
                echo "Empty fields !";
            return $this->signUpFormAction();
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

        if($this->checkForErrors($errorArray))
            return $this->changePasswordFormAction();

        //Both new password must be identical

        if ($_REQUEST['newPassword2'] !=  $_REQUEST['newPassword1']){
            array_push($errorArray, 'Confirm new password!');
        } else{
            if($_REQUEST['password1'] == $_REQUEST['newPassword1'])
                array_push($errorArray, "Passowrd must differ!");
        }

        if($this->checkForErrors($errorArray))
            return $this->changePasswordFormAction();

        //Check old password
        $oldPasswordIsOk = $this->model->checkPassword();
        if (!$oldPasswordIsOk){
            array_push($errorArray, 'Old Password is not correct');
        }else{
            //Change password
            $setPassword = $this->model->changePassword();
            if ($setPassword){
                //return $this->logoutUserAction();
                header('Location: index.php?action=logout');
                exit;
            }
            else{
                echo "Database error";
                return $this->changePasswordFormAction();            }
        }

        if($this->checkForErrors($errorArray))
            return $this->changePasswordFormAction();
    }

    //Checks if the new email is not taken
    //Changes the email address & Returns to LoginPage
    //Uses Header
    public function changeEmailAction(){
        $errorArray = [];
        //No empty fields

        if(empty($_REQUEST['email'])) array_push($errorArray, 'Old email required!');
        if(empty($_REQUEST['newEmail'])) array_push($errorArray, 'New email required!');

        if($this->checkForErrors($errorArray))
            return $this->changeEmailFormAction();

        //Email addresses must be different

        if($_REQUEST['email'] == $_REQUEST['newEmail'])
            array_push($errorArray, "Email addresses must differ!");


        if($this->checkForErrors($errorArray))
            return $this->changeEmailFormAction();


        //Check old email
        $isUsed = $this->model->checkUser();
        $isValid = $this->model->checkEmail();
        if ($isUsed !=1 ){
            array_push($errorArray, 'Old email is not correct !');
        }
        if ($isValid != 0) {
            array_push($errorArray, 'Email address is taken !');
        }

        if($this->checkForErrors($errorArray))
            return $this->changeEmailFormAction();


        //Change email
        $setEmail = $this->model->changeEmail();
        if ($setEmail){
            return $this->redirect('index.php?action=logout');
        }
        else{
            echo "Database error";
            return $this->changeEmailFormAction();
        }
    }

    // Checks if the password is correct
    // Deletes the user data from the database
    // Redirects to Login Page
    public function deleteAccountAction(){
        $errorArray = [];

        //password field must be complete
        if (empty($_REQUEST['password1'])) array_push($errorArray, 'Password Required');
        if  ($this->checkForErrors($errorArray)){
            return $this->deleteAccountFormAction();
        }
        //password must be correct
        $isCorrect = $this->model->checkPassword();
        if (!$isCorrect) array_push($errorArray, 'Password is not correct!');
        if  ($this->checkForErrors($errorArray)){
            return $this->deleteAccountFormAction();
        }

        //password is correct

        $isDeleted = $this->model->deleteAccount();
        if ($isDeleted){
            //return $this->logoutUserAction();
            $this->redirect('index.php?action=logout');
        }else{
            echo "Database error!";
            return $this->deleteAccountFormAction();
        }


    }

    /// FILES ACTIONS

    //Upload files
    //Redirects to home page after upload
    public function uploadFiles(){

        ///Upload files to directory

        // Directory where the file is going to be placed
        $target_dir = 'MVC'.DIRECTORY_SEPARATOR.'Uploads';

        //Path of the file to be uploaded
        $uploadOk = true;

        //Holds the file extension of the file
        $uploadedFileName = $_FILES['fileToUpload']['name'];
        $imageFileType = strtolower(pathinfo($uploadedFileName,PATHINFO_EXTENSION));

        //Checks if the image is an actual image or a fake image
        if(isset($_REQUEST['submit'])){
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);

            if ($check !== false){
                //echo 'File is an image -'.$check['mime'].'.';
                $uploadOk = true;
            } else {
                echo 'File is not an image';
                $uploadOk = false;
            }
        }

        //Check if file already exists in the Uploads folder
        /*
        if (file_exists($destination_file)){
            echo "Sorry, file already exists.";
            $uploadOk = false;
        }
        */

        //Limit file size to 500kb
        if ($_FILES['fileToUpload']['size']>500000){
            echo "Sorry, your file is too large";
            $uploadOk = false;
        }

        //Limit file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)){
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = false;
        }

        $myuserid = $_SESSION['id'];
        $myImageName = md5($myuserid . basename($uploadedFileName));
        $myImageName .= ('.'.$imageFileType);

        //Check if the file already exists in the database ( for the current user)
        $fileIsUploaded = $this->model->checkUserFile($myImageName);
        if (!$fileIsUploaded){
            echo "File is already uploaded by user!";
            $uploadOk = false;
        }

        if (!$uploadOk) {
            echo "Sorry, your file was not uploaded";
            return $this->loggedInFormAction();
        }

        $destinationFile = $target_dir. DIRECTORY_SEPARATOR . $myImageName;

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destinationFile)){
        //if (move_uploaded_file($myImageName, $destination_file)){
            echo "The file ".basename($uploadedFileName)." has been saved.";
            //rename($_FILES['fileToUpload']['name'], $myImageName);

            $succes = $this->model->uploadFileData($myImageName);
            if ($succes){
                echo "The file".basename($_FILES['fileToUpload']['tmp_name'], $destinationFile)."has been stored in the database.";
                $this->redirect('index.php');
            } else {
                echo "Error in saving the image name to the database";
                $this->loggedInFormAction();
            }

        }else{
            echo "Sorry, there was an error uploading your file.";
            return $this->loggedInFormAction();

        }

        //Upload files to database
        /*
        //Path of the file to be uploaded
        $destination_file = $_FILES['fileToUpload']['name'];
        $uploadOk = true;
        var_dump($_FILES['fileToUpload']);

        //Holds the file extension of the file
        $imageFileType = strtolower(pathinfo($destination_file,PATHINFO_EXTENSION));

        //Cheks if the image is an actual image or a fake image
        if(isset($_REQUEST['submit'])){
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);

            if ($check !== false){
                echo 'File is an image -'.$check['mime'].'.';
                $uploadOk = true;
            } else {
                echo 'File is not an image';
                $uploadOk = false;
            }
        }

        //Limit file size to 500kb
        if ($_FILES['fileToUpload']['size']>500000){
            echo "Sorry, your file is too large";
            $uploadOk = false;
        }

        //Limit file type
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)){
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = false;
        }

        if (!$uploadOk) {
            echo "Sorry, your file was not uploaded";
            return $this->loggedInFormAction();
        }

        echo "<br>Everything works fine";

        $this->model->uploadFile();
        */

    }

    //View and Controller intersect here
    //Display active user's files
    public function displayUserFiles(){
        if (!$this->isUserLoggedIn()){
            echo "An active user is required for this task";
            $this->redirect('index.php');
        }
        $userFiles = $this->model->getUserFiles();
        //var_dump($userFiles);

        $count = mysqli_num_rows($userFiles);
//$this->view->set('images', $userFiles);
        if($count == 0)
            echo "You have not uploaded any files ";
        else{
            while ($row = mysqli_fetch_array($userFiles,MYSQLI_ASSOC)){
                echo $row['Image'];
                $imageURL = 'MVC'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$row['Image']; ?>
                <img src="<?php echo $imageURL; ?>" alt="" />
                <?php
            }
        }
    }

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
    private function isUserLoggedIn()
    {
        return
            isset($_SESSION['user'])
            && isset($_SESSION['id'])
            && $_SESSION['id'] > 0
        ;
    }

    // Redirects to given location
    private function redirect(string $location)
    {
        header('Location: ' . $location);
        exit;
    }

}