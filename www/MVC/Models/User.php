<?php

namespace MVC\Models;

use MVC\Models\Files;

class User{
    public function connect()
    {
        $db = new \mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        if ($db->connect_error){
            die("Connection failed :". $db->connect_error);
        }
        return $db;
    }

    ///Verify Database
    //True  -> user and password successfully found
    //False -> no / more than one user & password found
    public function getLogin($user, $password){
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$user);
        $mypassword = mysqli_real_escape_string($db,sha1($password));

        // Select query
        $sql = "SELECT UserId FROM Users WHERE User = '$myusername' and Password = '$mypassword';";
        $result = mysqli_query($db,$sql);
        //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        //$active = $row['active'];

        $count = mysqli_num_rows($result);
        mysqli_close($db);

        if ($count == 1){
            return true;
        }
        echo "User or Password invalid!";
        return false;

    }

    //-1 error in data
    // returns the count of the results
    public function checkUser($user, $email):int {
        $db = $this->connect();

        $myusername = mysqli_real_escape_string($db,$user);
        $myemail = mysqli_real_escape_string($db,$email);

        // Select query
        $sql = "SELECT UserId FROM Users WHERE User = '$myusername' and Email = '$myemail';";

        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        mysqli_close($db);

        return $count;
    }

    public function checkEmail($email):int {
        $db = $this->connect();

        $myemail = mysqli_real_escape_string($db,$email);

        // Select query
        $sql = "SELECT UserId FROM Users WHERE Email = '$myemail';";
        $result = mysqli_query($db,$sql);

        $count = mysqli_num_rows($result);

        mysqli_close($db);

        return $count;
    }

    //True -> the old password is correct
    //False -> wrong password
    public function checkPassword($user, $password):bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$user);
        $mypassword = mysqli_real_escape_string($db,$password);
        $mypassword = sha1($mypassword);

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

    //Returns the privilege of the current user
    public function getPrivilege($user){
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$user);

        // Select query
        $sql = "SELECT UserType FROM Users WHERE User = '$myusername';";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_row($result);

        mysqli_close($db);
        return $row[0];
    }

    ///Modify Database

    // True -> task performed successfully
    // False -> task failed
    public function changePassword($user, $password):bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$user);
        $mypassword = mysqli_real_escape_string($db,$password);

        $mypassword = sha1($mypassword);

        $sql = "UPDATE Users SET Password = '$mypassword', PasswordTimestamp = now() where User = '$myusername';";

        $result = mysqli_query($db, $sql);
        var_dump($result);

        mysqli_close($db);

        if (!$result)
            return false;
        return true;

    }

    public function changeEmail($user, $email):bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$user);
        $myemail = mysqli_real_escape_string($db,$email);

        $sql = "UPDATE Users SET Email = '$myemail' where User = '$myusername'";

        $result = mysqli_query($db, $sql);

        mysqli_close($db);
        return $result;
    }

    public function createAccount($user, $password, $email):bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$user);
        $mypassword = mysqli_real_escape_string($db,$password);
        $myemail = mysqli_real_escape_string($db,$email);

        $mypassword = sha1($mypassword);

        //$sql ="INSERT INTO Users (User, Password, Email) VALUES ('$myusername', '$mypassword', '$myemail');";
        $sql ="INSERT INTO Users (User, Password, Email, PasswordTimestamp) VALUES ('$myusername', '$mypassword', '$myemail', now());";

        $result = mysqli_query($db, $sql);

        mysqli_close($db);

        if (!$result){
            return false;
        }
        $_SESSION['user'] = $_REQUEST['newUser'];
        return true;
    }

    public function deleteAccount($myusername):bool{
        $db = $this->connect();
        $myusername = mysqli_real_escape_string($db,$myusername);

        $sql ="DELETE FROM Users where User = '$myusername';";

        $result = mysqli_query($db, $sql);
        mysqli_close($db);

        if (!$result){
            return false;
        }
        return true;
    }

    ///ADMIN FUNCTIONS

    public function getAllUsers(){
        $db = $this -> connect();

        $sql = "SELECT UserId , User, Email, UserType FROM Users ORDER BY UserId;";
        $result = mysqli_query($db, $sql);

        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_close($db);

        return $rows;
    }

}
