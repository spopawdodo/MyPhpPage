<!DOCTYPE html>
<html lang="en">
<head>

    <title> Settings | Change Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href ='css/bootstrap.min.css' rel = 'stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body>

<div class = "container">
<h2>Change Your Password</h2>

<form action="index.php" method = "post">
    <div class = "form-group">
    <label for="password1">Old Password : </label>
        <input type = "password" class="form-control" name="password1"> <br>
    <label for="newPassword1">New Password : </label>
        <input type = "password" class="form-control" name="newPassword1"> <br>
    <label for="newPassword2">Confirm New Password : </label>
        <input type="password" class="form-control" name="newPassword2"><br>
    <input type = "hidden" name = "action" value = "changePassword">

    <p class = "text-warning">You will be logged out from your account!</p>

    <input type="submit" value="Change Password" class = "btn btn-primary">
    </div>
</form>


<form action="index.php" method = "post">
    <div class="form-group">
    <input type = "hidden" name = "action" value = "userLoggedIn">

        <p>I changed my mind</p>
    <input type="submit" value="Go back to homepage" class = "btn btn-light">
    </div>
</form>

</div>
</body>
</html>
