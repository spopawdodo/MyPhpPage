<?php

define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'myDatabase');


class Model{

    public function connect()
    {
        $db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        if ($db->connect_error){
            die("Connection failed :". $db->connect_error);
        }
        //echo "Connected succesfully to myDatabase";
        return $db;
    }

    ///Verify Database

    public function getLogin(){
        $db = $this->connect();
        if (isset($_REQUEST['user']) && isset($_REQUEST['password'])){
            $myusername = mysqli_real_escape_string($db,$_REQUEST['user']);
            $mypassword = mysqli_real_escape_string($db,sha1($_REQUEST['password']));
        }
        else{
            echo "User and Password are required!";
            return "User and Password are required!";

        }

        // Select query
        $sql = "SELECT UserId FROM Users WHERE User = '$myusername' and Password = '$mypassword';";
        $result = mysqli_query($db,$sql);
        //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        //$active = $row['active'];

        $count = mysqli_num_rows($result);
        mysqli_close($db);

        if ($count == 1){
            //var_dump($result);
        }else{
            echo "User or Password invalid!";
            return "User or Password invalid!";
        }

        return "UserPage";
    }

    //-1 error in data
    // returns the count of the results
    public function checkUser():int {
        $db = $this->connect();
        if (isset($_SESSION['user'])){
            $myusername = mysqli_real_escape_string($db,$_SESSION['user']);
        } else {if(isset($_REQUEST['newUser'])) {
            $myusername = mysqli_real_escape_string($db,$_REQUEST['newUser']);
        } else {
            echo "Username is required! ";
            return -1;
        }}
        if (isset($_REQUEST['email'])){
            $myemail = mysqli_real_escape_string($db,$_REQUEST['email']);
        }
        else{
            echo "Email is required! ";
            return -1;

        }
        // Select query
        $sql = "SELECT UserId FROM Users WHERE User = '$myusername' or Email = '$myemail';";
        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        mysqli_close($db);
        var_dump($count);
        return $count;
    }

    public function checkEmail():int {
        $db = $this->connect();
        var_dump($_REQUEST);
        if (isset($_REQUEST['email'])){
            $myemail = mysqli_real_escape_string($db,$_REQUEST['newEmail']);
        }
        else{
            echo "Email is required! ";
            return -1;
        }
        // Select query
        $sql = "SELECT UserId FROM Users WHERE Email = '$myemail';";
        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        mysqli_close($db);
        var_dump($count);
        return $count;
    }

    //True -> the old password is correct
    //False -> wrong password
    public function checkPassword():bool{
        $db = $this->connect();
        if (isset($_SESSION['user']) && isset($_REQUEST['password1'])){
            $myusername = mysqli_real_escape_string($db,$_SESSION['user']);
            $mypassword = mysqli_real_escape_string($db,$_REQUEST['password1']);
            $mypassword = sha1($mypassword);
        }
        else{
            echo "All password fields are required! ";
            return true;

        }
        // Select query
        $sql = "SELECT UserId FROM Users WHERE User = '$myusername' and Password = '$mypassword';";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);

        if ($result->num_rows == 1){
            return true;
        }
        return false;
    }

    //Returns the ID of the current user
    public function getID($db):int{
        if (isset($_SESSION['user'])){
            $myusername = mysqli_real_escape_string($db,$_SESSION['user']);
        }
        else{
            echo 'No active session!';
            return -1;
        }

        $sql = "SELECT UserId FROM Users WHERE User = '$myusername';";
        $result = mysqli_query($db,$sql);

        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

        if ($result->num_rows == 1){
            return $row['UserId'];
        }
        return -1;
    }

    public function getUserId():int{
        $db = $this->connect();

        $id = $this->getID($db);

        mysqli_close($db);
        return $id;
    }

    ///Modify Database

    // True -> task performed successfully
    // False -> task failed

    public function changePassword():bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$_SESSION['user']);
        $mypassword = mysqli_real_escape_string($db,$_REQUEST['newPassword1']);

        $mypassword = sha1($mypassword);

        $sql = "UPDATE Users SET Password = '$mypassword', PasswordTimestamp = now() where User = '$myusername';";

        $result = mysqli_query($db, $sql);
        var_dump($result);

        mysqli_close($db);

        if (!$result)
            return false;
        return true;

    }

    public function changeEmail():bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$_SESSION['user']);
        $myemail = mysqli_real_escape_string($db,$_REQUEST['newEmail']);

        $sql = "UPDATE Users SET Email = '$myemail' where User = '$myusername'";

        $result = mysqli_query($db, $sql);
        var_dump($result);

        mysqli_close($db);

        if (!$result)
            return false;
        return true;

    }

    public function createAccount():bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$_REQUEST['newUser']);
        $mypassword = mysqli_real_escape_string($db,$_REQUEST['password1']);
        $myemail = mysqli_real_escape_string($db,$_REQUEST['email']);

        $mypassword = sha1($mypassword);

        //$sql ="INSERT INTO Users (User, Password, Email) VALUES ('$myusername', '$mypassword', '$myemail');";
        $sql ="INSERT INTO Users (User, Password, Email, PasswordTimestamp) VALUES ('$myusername', '$mypassword', '$myemail', now());";

        $result = mysqli_query($db, $sql);
        var_dump($result);
        mysqli_close($db);

        if (!$result){
            return false;
        }
        $_SESSION['user'] = $_REQUEST['newUser'];
        return true;
    }

    public function deleteAccount():bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$_SESSION['user']);

        $sql ="DELETE FROM Users where User = '$myusername';";

        $result = mysqli_query($db, $sql);
        mysqli_close($db);

        if (!$result){
            return false;
        }
        return true;
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

    public function uploadFileData($myImageName):bool{
        $db = $this->connect();

        $myuserid = $_SESSION['id'];

        $sql = "INSERT INTO Images (Image, UserId, UploadTime) VALUES ('$myImageName','$myuserid', now())";

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
    public function checkUserFile($myImageName):bool{
        $db = $this->connect();
        if (isset($_SESSION['id']) && isset($_FILES['fileToUpload']['name'])){
            $myuserid = mysqli_real_escape_string($db,$_SESSION['id']);
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

    //Returns the files saved for the logged in user
    public function getUserFiles(){
        $db = $this->connect();

        $myuserid = mysqli_real_escape_string($db,$_SESSION['id']);

        $sql = "SELECT Image FROM Images WHERE UserId = '$myuserid';";
        $result = mysqli_query($db,$sql);

        mysqli_close($db);

        return $result;

    }
}
