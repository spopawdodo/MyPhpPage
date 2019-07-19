<!DOCTYPE html>
<html lang="en">
<head>

    <title> My Login Page</title>

</head>

<body>

<h1>SignUp to our site</h1>

<form action="index.php" method = "post">
    <label>Username : </label> <input type = "text" name = "newUser"> <br>
    <label>Email : </label> <input type = "email" name = "email"> <br>
    <label>Password : </label> <input type = "password" name="password1"> <br>
    <label>Confirm Password : </label> <input type="password" name="password2"><br>
    <input type = "hidden" name = "action" value = "createAccount">
    <input type="submit" value="Sign Up">

</form>


<form action = "index.php" method = "post">
    Already a user? <br>
    <input type = "hidden" name = "action" value = "authenticate">
    <input type = "Submit" value = "Log In">
</form>
</body>

</html>
