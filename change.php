<?php
$mysql = new mysqli('localhost','root','','db_1');
session_start();

if (!empty($_SESSION['iduser'])) {
    $id = $_SESSION['iduser'];
    $thisresult = $mysql->query("SELECT * FROM `users` WHERE id='$id'");
    $thisuser = $thisresult->fetch_assoc();
}

if (empty($_POST['changeuserid'])) {
    $id = $_SESSION['iduser'];
} else {
    $id = $_POST['changeuserid'];
}

$result = $mysql->query("SELECT * FROM `users` WHERE id='$id'");
$user = $result->fetch_assoc();

        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $first_name = $_POST['fname'];
            $last_name = $_POST['lname'];
            $email = $_POST['email'];
            $login = $_POST['login'];
            $password = $_POST['psw'];
            $r_password = $_POST['r_psw'];
            $role = $_POST['role'];

            if ($password == $r_password) {
                $mysql -> query("UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', login='$login', password='$password', role_id='$role' WHERE id='$id'");
                $mysql->close();
                if ($_SESSION['iduser'] == $id) {
                    header('Location: exit.php');
                } else {
                    header("Location: index.php");
                }
            } else {
                echo "Пароли не совпадают";
                exit();
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="assets/scripts.js"></script>
    <title>Moroslin Sergey KS-32</title>
</head>
<body>
<div id="page-wrap">
    <header>
        <a class="logo" href="index.php"><img src="assets/img/logo.png" height="100" width="150" title="На главную" alt="Logo"></a>
        <span class="right">
			<?php if (empty($_SESSION['user'])) : ?>
                <span id="log"><button id="show_login_form" type="button" class="btn btn-light" onclick="show_login()">Log In</button></span>
                <span id="log"><button id="show_registration_form" type="button" class="btn btn-warning" onclick="show_registration()">Sign Up</button></span>
            <?php else: ?>
                <span id="log">
                    <?php if (!empty($thisuser['photo'])) :?>
                        <span><img height='52px' src="<?php print($thisuser['photo']) ?>" width='52px' alt="UserLogo"</span>
                    <?php endif;?>
                    <?php if ($_SESSION['role'] == 1) : ?>
                        <button class="btn btn-light" title="Type Of User" disabled>User</button>
                    <?php elseif ($_SESSION['role'] == 2) : ?>
                        <button class="btn btn-light" title="Type Of User" disabled>Administrator</button>
                    <?php endif; ?>
                    <a class="btn btn-light" href="change.php" title="Edit"><?=$_SESSION['user']?></a>
				    <a class="btn btn-danger" href="exit.php" title="Exit">Exit</a>
                </span>
            <?php endif; ?>
		</span>
    </header>
    <div class="container">
        <form action="registration.php" method="post" id="registration">
            <input type="hidden" name="id" value="<?php print($id) ?>">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" class="form-control" name="fname" placeholder="Enter First Name" value="<?php print($user['first_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="lname" id="last_name" placeholder="Enter Last Name" value="<?php print($user['last_name']) ?>" required>
                </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter E-Mail" value="<?php print($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" name="login" id="login" placeholder="Enter Login" value="<?php print($user['login']) ?>" required>
                </div>
            <div class="form-group">
                <label for="reg_password">Password</label>
                <input type="password" class="form-control" name="psw" id="reg_password" minlength="6" value="<?php print($user['password']) ?>" placeholder="Enter Password" required>
                <small class="form-text text-muted">Min-lenth password 6 simbols</small>
            </div>
            <div class="form-group">
                <label for="reg_re_password">Re Password</label>
                <input type="password" class="form-control" name="r_psw" id="reg_re_password" value="<?php print($user['password']) ?>" placeholder="Re-Enter Password" required>
                </div>
            <?php if($_SESSION['role'] == 2):?>
                <?php if ($user['role_id'] == 1):?>
                    <div class="form-group">
                        <label for="role">Change Role</label>
                        <select class="custom-select custom-select-sm" name="role">
                            <option value="1" selected>User</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>
                <?php elseif ($user['role_id'] == 2):?>
                    <div class="form-group">
                        <label for="role">Change Role</label>
                        <select class="custom-select custom-select-sm" name="role">
                            <option value="1">User</option>
                            <option value="2" selected>Admin</option>
                        </select>
                    </div>
                <?php endif; ?>
            <?php elseif ($_SESSION['role'] == 1):?>
                <input type="hidden" value="1" name="role">
            <?php endif; ?>
            <input id="registration_button" type="submit" class="btn btn-primary" value="Change">
        </form>
        <br>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" multiple>
                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                </div>
                <div class="input-group-append">
                    <input type="hidden" name="changeuserid" value="<?php print($id) ?>">
                    <input type="submit" value="Upload Image" name="submitphoto" class="btn btn-outline-secondary">
                </div>
            </div>
        </form>
    </div>
</div>
<footer>
    <div class="center">V. N. Karazin Kharkiv National University | Moroslin Sergey | 2019</div>
</footer>

</body>
</html>