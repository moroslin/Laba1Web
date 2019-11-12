<?php
$mysql = new mysqli('localhost','root','','db_1');
$id = $_COOKIE['iduser'];
$result = $mysql->query("SELECT * FROM `users` WHERE id='$id'");
$user = $result->fetch_assoc();
$mysql->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Moroslin Sergey KS-32</title>
</head>
<body>
<div id="page-wrap">
    <header>
        <a class="logo" href="index.php"><img src="assets/img/logo.png" height="100" width="150" title="На главную" alt="Logo"></a>
        <span class="right">
			<?php if (empty($_COOKIE['user'])) : ?>
                <span id="log"><a class="waves-effect waves-light btn-large" href="auth.php" title="Войти">Log In</a></span>
                <span id="log"><a class="waves-effect waves-light btn-large" href="registration.php" title="Зарегистрироваться">Sign Up</a></span>
            <?php else: ?>
                <span id="log">
                    <?php if ($_COOKIE['role'] == 1) : ?>
                        <a href="" class="waves-effect waves-light btn-large disabled" title="Type Of User">User</a>
                    <?php elseif ($_COOKIE['role'] == 2) : ?>
                        <a href="" class="waves-effect waves-light btn-large disabled" title="Type Of User">Administrator</a>
                    <?php endif; ?>
                    <a class="waves-effect waves-light btn-large" href="upload_img.php" title="Upload">Upload</a>
                    <a class="waves-effect waves-light btn-large" href="change.php" title="Edit"><?=$_COOKIE['user']?></a>
				    <a class="waves-effect waves-light btn-large" href="exit.php" title="Exit">Exit</a>
                </span>
            <?php endif; ?>
		</span>
    </header>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>
<footer>
    <div class="center">V. N. Karazin Kharkiv National University | Moroslin Sergey | 2019</div>
</footer>
</body>
</html>