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
    <h3> UserTable </h3>
    <table class = "table table-bordered">
        <thead>
        <tr>
            <th>UserId</th>
            <th>User</th>
            <th>Email</th>
            <th>UserType</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $userInfo = $this->get('User');
        foreach($userInfo as $key=>$value): ?>
        <tr>
            <td> <?= $value['UserId'];?></td>
            <td> <?= $value['User'];?></td>
            <td> <?= $value['Email'];?></td>
            <td> <?= $value['UserType'];?></td>
            <td>
                <a class = "nav-link" href = "index.php?action=deleteUserAccount&userId=<?=$value['UserId']?>"> Delete Account </a>
            </td>
        </tr>
        </tbody>
        <?php
        endforeach; ?>
    </table>
</div>
</body>
</html>