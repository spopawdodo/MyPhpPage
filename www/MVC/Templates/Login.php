<!DOCTYPE html>
<html lang="en">
<head>

    <title> My Login Page</title>

</head>

<body>

<form action="index.php" method = "post">
    <label>Username :</label> <input type = "text" name = "user" value = <?php isset($_POST['user']) ? $_REQUEST['user'] : "" ?> > <br>
    <label>Password :</label> <input type = "password" name="password"> <br>
    <input type = "hidden" name = "action" value = "authenticate">
    <input type="submit" value="Log in">

</form>

<form action = "index.php" method = "post">
    Not a user ? <br>
    <input type = "hidden" name = "action" value = "createAccount">
    <input type = "Submit" value = "Sign Up">
</form>

</body>

</html>
