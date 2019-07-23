<!DOCTYPE html>
<html lang="en">
<head>

    <title> My Login Page</title>
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
    <header>
        <h2>Welcome!</h2>
    </header>

<form action="index.php" method = "post">
    <div class = "form-group">
    <label for ="user">Username:</label>
        <input type = "text" class="form-control" placeholder="Enter Username" name = "user" value = <?php isset($_POST['user']) ? $_REQUEST['user'] : "" ?> > <br>
    <label for="password">Password :</label>
        <input type = "password" class = "form-control" placeholder="Enter Password" name="password"> <br>
    <input type = "hidden" name = "action" value = "authenticate">
    <input type="submit" class = "btn btn-primary"value="Log in">
    </div>
</form>

<form action = "index.php" method = "post">
    Not a user ? <br>
    <input type = "hidden" name = "action" value = "createAccount">
    <input type = "Submit" class="btn bg-light"value = "Sign Up">
</form>

</div>

</body>

</html>
