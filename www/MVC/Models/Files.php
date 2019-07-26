<?php

namespace MVC\Models;

use MVC\Models\User;

class Files{

    public function connect()
    {
        $db = new \mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        if ($db->connect_error){
            die("Connection failed :". $db->connect_error);
        }
        return $db;
    }

    ///File functions
    /*
    public function uploadFile():bool{
        $db = $this->connect();

        $myuserid = $this->getID($db);

        $myuserid = mysqli_real_escape_string($db,$myuserid);
        $image = base64_encode(file_get_contents($_FILES['fileToUpload']['tmp_name']));

        $sql = "INSERT INTO Images (Image, UserId, UploadTime_TIME) VALUES ('$image','$myuserid', now())";
        print_r($sql);
        $result = mysqli_query($db,$sql);


        if (!$result) { // Error handling
            echo "Something went wrong! :(";
        }

        mysqli_close($db);
        return true;
    }
    */

    public function getFileExtension($filename){
        $db = $this->connect();

        // Select query
        $sql = "SELECT Extension FROM Images WHERE Image = '$filename';";

        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        $rows = mysqli_fetch_array($result,MYSQLI_ASSOC);
        mysqli_close($db);
        if ($count != 1)
            return "";
        return $rows['Extension'];
    }

    public function uploadFileData( $userId ,$myImageName, $imageFileType, $imageDescription):bool{
        $db = $this->connect();

        $sql = "INSERT INTO Images (Image, UserId, UploadTime, Extension, ImageDescription) VALUES ('$myImageName','$userId', now(), '$imageFileType', '$imageDescription')";

        $result = mysqli_query($db,$sql);

        mysqli_close($db);
        if (!$result) { // Error handling
            echo "Something went wrong! :(";
            return false;
        }
        return true;
    }

    //False -> user has already uploaded the file
    //True -> user has not uploaded the file
    public function checkUserFile($myuserid, $myImageName):bool{
        $db = $this->connect();
        if (isset($_FILES['fileToUpload']['name'])){
            $myuserid = mysqli_real_escape_string($db,$myuserid);
            $myimage = mysqli_real_escape_string($db,$myImageName);
        }
        else{
            echo " Active User and file are required! ";
            return false;
        }
        // Select query
        $sql = "SELECT ImageId FROM Images WHERE UserId = '$myuserid' and Image = '$myimage';";

        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        mysqli_close($db);
        if ($count != 0)
            return false;
        return true;
    }

    //True -> delete successful
    //False-> error
    public function deleteFile($userId, $image):bool{
        $db = $this->connect();
        $myuserid = mysqli_real_escape_string($db,$userId);

        $sql ="DELETE FROM Images where UserId = '$myuserid' and Image = '$image';";
        $result = mysqli_query($db, $sql);
        mysqli_close($db);

        return $result;
    }

    //Returns the files saved for the logged in user
    public function getUserFiles($userId){
        $db = $this->connect();

        $myuserid = mysqli_real_escape_string($db,$userId);

        $sql = "SELECT Image, ImageDescription FROM Images WHERE UserId = '$myuserid';";
        $result = mysqli_query($db,$sql);

        $rows = mysqli_fetch_all($result,MYSQLI_ASSOC);

        mysqli_close($db);
        return $rows;

    }


    public function getAllFiles(){
        $db = $this -> connect();

        $sql = "SELECT DISTINCT UserId FROM Images ORDER BY UserId;";
        $result = mysqli_query($db, $sql);

        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_close($db);

        return $result;
    }

}
