<?php


namespace MVC\Controllers;
/*
use MVC\Controllers\Controller;

use MVC\Models\User;
*/
use MVC\Views\View;
use MVC\Models\Files;
use MVC\Controllers\FormController;
use MVC\Controllers\CheckController;


class FileController
{
    private $modelFiles;
    private $checkController;
    private $formController;
    private $view;

    public function __construct()
    {
        $this->modelFiles = new Files();
        $this->checkController = new CheckController();
        $this->formController = new FormController();
        $this->view = new View();
    }

    public function displayFiles($userId){
        if (!$this->checkController->isUserLoggedIn()){
            echo "You need to be logged in";
            $this->checkController->redirect('index.php?action=logout');
        }
        $userFiles = $this->modelFiles->getUserFiles($userId);
        $count = count($userFiles);

        if($count== 0)
            echo "You have not uploaded any files ";
        else{
            if ($this->checkController->isAdmin()){
                $this->view->setUser($userId);
            } else {
                $this->view->setUser($_SESSION['user']);
            }
            $this->view->set('userFiles', $userFiles);
            $this->view->display('UserFiles',true, false);
        }
    }


    //Download file
    public function downloadFile(){
        if (!$this->checkController->isUserLoggedIn() && empty($_REQUEST['fileName'])){
            $this->checkController->redirect('index.php');
        }
        $filename = $_REQUEST['fileName'];

        $filepath = 'MVC'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$filename;

        $fileExtension = $this->modelFiles->getFileExtension($filename);
        if (empty($fileExtension)){
            echo "File has no extension!";
            return $this->checkController->redirect('index.php');
        }
        $filename = $_SESSION['user'].date('mdYhi').'.'.$fileExtension;

        if (file_exists($filepath)){
            ob_end_clean();
            header("Cache-Control: public");
            header("Content-Description: FIle Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/jpg");
            header("Content-Transfer-Encoding: binary");

            readfile($filepath);
            exit;
        }
        else{
            echo "File does not exist";
        }

    }

    //Delete a file
    //Redirects to index.php
    public function deleteFile(){
        $errorArray = [];

        if (!$this->checkController->isUserLoggedIn())array_push($errorArray, 'No active user!');
        if (!isset($_REQUEST['fileName'])) array_push($errorArray, 'No file requested');
        if  ($this->checkController->checkForErrors($errorArray)){
            var_dump($errorArray);
            $this->checkController->redirect('index.php');
        }

        $image = $_REQUEST['fileName'];
        $userId = $_SESSION['id'];
        $isUserFile = $this->modelFiles->checkUserFile($userId, $image);
        if (!$this->checkController->isAdmin()){
        $isDeleted = $this->modelFiles->deleteFile($userId, $image);
        if ($isDeleted){
            chdir($_SERVER['DOCUMENT_ROOT']);
            var_dump(realpath($image));
            if(unlink(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$image))
                $this->checkController->redirect('index.php');
            else{
                echo "Directory file error!";
                return $this->checkController->redirect('index.php');
            }
        }else{
            echo "Database error!";
            return $this->checkController->redirect('index.php');
        }
        } else {
            echo ("admin can't yet delete this picture");
            die();
        }
    }

    public function checkText(&$myImageDescription){
        $forbiddenWords = ['banana', 'mountain'];


    }


    //Upload files
    //Redirects to home page after upload
    public function uploadFiles(){

        if ($_FILES['fileToUpload']['size'] == 0){
            echo "Please select a file";
            return $this->formController->loggedInFormAction();
        }
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

        $myImageDescription = $_REQUEST['imageDescription'] ?? "";
        if (!empty($myImageDescription)){
            $this->checkText($myImageDescription);
        }

        //Check if the file already exists in the database ( for the current user)
        $fileIsUploaded = $this->modelFiles->checkUserFile($myuserid, $myImageName);
        if (!$fileIsUploaded){
            echo "File is already uploaded by user!";
            $uploadOk = false;
        }

        if (!$uploadOk) {
            echo "Sorry, your file was not uploaded";
            return $this->checkController->redirect('index.php');
        }

        $destinationFile = $target_dir. DIRECTORY_SEPARATOR . $myImageName;

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destinationFile)){
            //if (move_uploaded_file($myImageName, $destination_file)){
            echo "The file ".basename($uploadedFileName)." has been saved.";

            $success = $this->modelFiles->uploadFileData($myuserid,$myImageName,$imageFileType, $myImageDescription);
            if ($success){
                echo "The file".basename($_FILES['fileToUpload']['tmp_name'], $destinationFile)."has been stored in the database.";
                $this->checkController->redirect('index.php');
            } else {
                echo "Error in saving the image name to the database";
                $this->formController->loggedInFormAction();
            }

        }else{
            echo "Sorry, there was an error uploading your file.";
            return $this->formController->loggedInFormAction();

        }
    }
}