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
    if ($_SESSION['id'] <= 0){
        echo "You are not a user !<br> You must log in.";

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

        <form action="index.php" method = "post" enctype="multipart/form-data">
            <div class = "form-group">
            Select image to upload: <br>
            <input type = "hidden" name = "action" value = "uploadFiles">
            <input type="file" name="fileToUpload" id="fileToUpload">
                <input type = "text" name = "imageDescription" placeholder="Picture description" class = "form-control" rows = "3">

                <input type = "Submit" value = "Upload Image" name = 'submit' class = "btn btn-primary">
            </div>
        </form>
    <?php }?>

    </div>
</body>

</html>

