<!DOCTYPE html>
<html lang="en">
<head>

    <title> Delete account</title>
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
<h2>Are you sure ?</h2>

<p class = "text-danger"> Your account and all your data will be erased</p>
<form action="index.php" method = "post">
    <div class = "form-group">
    <label for="password1">Please type your password to confirm:</label>
    <input type = "password" class="form-control" name="password1"> <br>
    <input type = "hidden" name = "action" value = "deleteAccount">
    <input type="submit" value="Delete" class="btn btn-danger">
    </div>
</form>

<form action="index.php" method = "post">
    <div class = "form-group">
    <input type = "hidden" name = "action" value = "userLoggedIn">

    <input type="submit" value="I changed my mind" class = "btn btn-light">
    </div>
</form>

</div>
</body>
</html>

