<!DOCTYPE html>
<html lang="en">
<head>

    <title> Delete account</title>

</head>

<body>

<h1>Are you sure ?</h1>

<p> Your account and all your data will be erased</p>
<form action="index.php" method = "post">
    <label>Please type your password to confirm: <br> </label> <input type = "password" name="password1"> <br>
    <input type = "hidden" name = "action" value = "deleteAccount">


    <input type="submit" value="Delete">

</form>

<form action="index.php" method = "post">
    <input type = "hidden" name = "action" value = "userLoggedIn">

    <input type="submit" value="I changed my mind">
</form>



</html>

