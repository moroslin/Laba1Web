<?php
$mysql = new mysqli('localhost','root','','db_1');
session_start();
if (!empty($_SESSION['iduser'])) {
    $id = $_SESSION['iduser'];
    $thisresult = $mysql->query("SELECT * FROM `users` WHERE id='$id'");
    $thisuser = $thisresult->fetch_assoc();
}
$id = $_POST['userid'];
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
    <div class="personcontainer">
        <table class="table table-striped">
        <tr>
            <th>Photo</th>
            <td><img width="100" src="<?php print($user["photo"])?>"></td>
        </tr>
        <tr>
            <th>ID</th>
            <td><?php print($user["id"]) ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php print($user["first_name"]) ?></td>
        </tr>
        <tr>
            <th>Surname</th>
            <td><?php print($user["last_name"]) ?></td>
        </tr>
        <tr>
            <th>email</th>
            <td><?php print($user["email"]) ?></td>
        </tr>
        <tr>
            <th>Role_id</th>
            <td><?php print($user["role_id"]) ?></td>
        </tr>
        </table>
    </div>
</div>
<footer>
    <div class="center">V. N. Karazin Kharkiv National University | Moroslin Sergey | 2019</div>
</footer>

<script type="text/javascript">
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

</body>
</html>