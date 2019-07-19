<!DOCTYPE html>
<html lang="en">
<head>

    <title> My Login Page</title>

</head>

<body>

<h1>Change Your Email</h1>

<form action="index.php" method = "post">
    <label>Old Email Address : </label> <input type = "email" name="email"> <br>
    <label>New Email Address : </label> <input type = "email" name="newEmail"> <br>
    <input type = "hidden" name = "action" value = "changeEmail">

    <p>You will be logged out from your account!</p>

    <input type="submit" value="Change Email">

</form>

<form action="index.php" method = "post">
    <input type = "hidden" name = "action" value = "userLoggedIn">

    <input type="submit" value="I changed my mind">
</form>



</html>

