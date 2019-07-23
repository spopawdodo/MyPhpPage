<!DOCTYPE html>
<html lang="en">
<head>

    <title> Sign Up</title>
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
    <h2>SignUp to our site</h2>
</header>

<form action="index.php" method = "post">
    <div class = "form-group">
    <label for=newUser">Username : </label>
        <input type = "text" class="form-control" name = "newUser"> <br>
    <label for="email">Email : </label>
        <input type = "email" class="form-control" name = "email"> <br>
    <label for="password1">Password : </label>
        <input type = "password" class="form-control" name="password1"> <br>
    <label for="password2">Confirm Password : </label>
        <input type="password" class="form-control" name="password2"><br>
    <input type = "hidden" name = "action" value = "createAccount">
    <input type="submit" value="Sign Up" class = "btn btn-primary">
    </div>
</form>


<form action = "index.php" method = "post">
    Already a user? <br>
    <input type = "hidden" name = "action" value = "authenticate">
    <input type = "Submit" value = "Log In" class = "btn bg-light">
</form>
</div>
</body>

</html>
