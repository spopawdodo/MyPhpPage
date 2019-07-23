<?php
$userFiles = $this->get('userFiles');

foreach($userFiles as $key=>$value):
    $imageURL = 'MVC'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$value['Image']; ?>
    <img src="<?php echo $imageURL; ?>" alt=""/>
    <br>
    <a href = "index.php?action=downloadFile&fileName=<?= urlencode($value['Image']); ?>">Download Image </a>
    <br>
    <a href = "index.php?action=deleteFile&fileName=<?= urlencode($value['Image']); ?>">Delete Image </a>


    <br><br>
    <?php
endforeach;