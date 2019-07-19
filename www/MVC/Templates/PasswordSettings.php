<!DOCTYPE html>
<html lang="en">
<head>

    <title> My Login Page</title>

</head>

<body>

<h1>Change Your Password</h1>

<form action="index.php" method = "post">
    <label>Old Password : </label> <input type = "password" name="password1"> <br>
    <label>New Password : </label> <input type = "password" name="newPassword1"> <br>
    <label>Confirm New Password : </label> <input type="password" name="newPassword2"><br>
    <input type = "hidden" name = "action" value = "changePassword">

    <p>You will be logged out from your account!</p>

    <input type="submit" value="Change Password">

</form>

<form action="index.php" method = "post">
    <input type = "hidden" name = "action" value = "userLoggedIn">

    <input type="submit" value="I changed my mind">
</form>



</html>
