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
<div class="container">
    <h3> <?php echo $this->getUser(); ?> Image Galery </h3>
    <div class = "card-deck">
<?php
$userFiles = $this->get('userFiles');
foreach($userFiles as $key=>$value):
    $imageURL = 'MVC'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$value['Image']; ?>

    <div class="card"  style = "max-width: 400px">
        <img class="card-img-top" src="<?php echo $imageURL; ?>" >
        <div class = "card-body">
            <p><?= $value['ImageDescription'];?></p>
            <a href = "index.php?action=downloadFile&fileName=<?= urlencode($value['Image']); ?>" class = "card-link">Download Image </a>
            <br>
            <a href = "index.php?action=deleteFile&fileName=<?= urlencode($value['Image']); ?>" class = "card-link">Delete Image </a>
        </div>
    </div>

<?php
endforeach; ?>
    </div>
</div>
</body>
</html>