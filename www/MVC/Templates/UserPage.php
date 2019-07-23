<!DOCTYPE html>
<html lang="en">
<head>

    <title> Logged in </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<body>

<?php
    if ($_SESSION['id'] <= 0){
        echo "You are not a user !<br> You must log in.";

?><div>
        <form action="../../index.php" method = "post">
            <input type = "hidden" name = "action" value = "authenticate">
            <input type="submit" value="Log in">

        </form>
</div>
<?php } else{ ?>

<p> Hello <?php echo ($_SESSION['user']) ?>!</p>


<form action = "index.php" method = "post">
    <input type = "hidden" name = "action" value = "logout">
    <input type="submit" value="Log out">

</form>


<form action="index.php" method = "post">
    Change your password: <br>
    <input type = "hidden" name = "action" value = "changePassword">
    <input type = "Submit" value = "Password Settings">
</form>

<form action="index.php" method = "post">
    Change your email address: <br>
    <input type = "hidden" name = "action" value = "changeEmail">
    <input type = "Submit" value = "Email Settings">
</form>
        <form action="index.php" method="post">
            Delete your account: <br>
            <input type = "hidden" name = "action" value = "deleteAccount">
            <input type = "Submit" value = "Delete">
        </form>

        <form action="index.php" method = "post" enctype="multipart/form-data">
            Select image to upload: <br>
            <input type = "hidden" name = "action" value = "uploadFiles">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type = "Submit" value = "Upload Image" name = 'submit'>
        </form>
    <?php }?>


</body>

</html>

