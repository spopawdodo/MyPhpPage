<!DOCTYPE html>
<html lang="en">
<head>

    <title> Logged in </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href ='css/bootstrap.min.css' rel = 'stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
<div>

    <?php
    if ($_SESSION['role'] != 'admin'){
    echo "You are not a admin!<br> You must log in.";

    ?>
</div>
<div>
    <form action="../../index.php" method = "post">
        <input type = "hidden" name = "action" value = "authenticate">
        <input type="submit" value="Log in">

    </form>
</div>
<?php } else{ ?>


<br>

<div class = "container">
    <h3> Hello <?php echo ($_SESSION['user']) ?>!</h3>

    <?php }?>

</div>
</body>

</html>

