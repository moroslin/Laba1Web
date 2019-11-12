<?php
    $mysql = new mysqli('localhost','root','','db_1');
    $result = $mysql->query("SELECT * FROM `users`");
    session_start();
    if (!empty($_SESSION['iduser'])) {
        $id = $_SESSION['iduser'];
        $thisresult = $mysql->query("SELECT * FROM `users` WHERE id='$id'");
        $thisuser = $thisresult->fetch_assoc();
    }
    $user = $result->fetch_all();
    $large = (count($user));
    $mysql->close();
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
        <div class="usertable">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>E-Mail</th>
                    <?php if(!empty($_SESSION['user'])):?><th>Login</th><?php endif; ?>
                                            <th>Role</th>
                                       <?php if (!empty($_SESSION['role'])) : ?>
                        <?php if($_SESSION['role'] == 2):?><th>Password</th><?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['role'])) : ?>
                        <?php if($_SESSION['role'] == 2):?><th colspan="2">Edit</th><?php endif; ?>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php
                    $a = 0;
                    while ($a < $large) :;
                ?>
                <tr>
                    <td>
                        <form action="person.php" method="post">
                            <input type="hidden" name="userid" value="<?php print($user[$a][0]) ?>">
                            <input type="submit" name="person" class="btn btn-dark" value="<?php print($user[$a][0]) ?>">
                        </form>
                    </td>
                    <td><?php
                        print($user[$a][1]);
                        ?></td>
                    <td><?php
                        print($user[$a][2]);
                        ?></td>
                    <td><?php
                        print($user[$a][3]);
                        ?></td>

                    <?php if (!empty($_SESSION['user'])) : ?>
                        <td><?php
                            print($user[$a][4]); // столбик логин
                            ?></td>
                    <?php endif; ?>

                    <td>
                        <?php if ($user[$a][7] == 1) : ?>
                            User
                        <?php elseif ($user[$a][7] == 2) :?>
                            Administrator
                        <?php endif; ?>
                    </td>

                    <?php if (!empty($_SESSION['role'])) : ?>

                        <?php if ($_SESSION['role'] == 2) : ?>
                        <td><?php print($user[$a][5]); // столбик пароль ?></td>
                        <td>
                            <form action="change.php" method="post">
                                <input type="hidden" name="changeuserid" value="<?php print($user[$a][0]) ?>">
                                <input type="submit" name="Change" class="btn btn-secondary" value="Change" title="Change">
                            </form>
                        </td>
                        <td>
                            <?php if ($_SESSION['iduser'] == $user[$a][0]) :?>
                                <form action="delete.php" method="post">
                                    <input type="hidden" name="deleteuserid" value="<?php print($user[$a][0]) ?>">
                                    <input type="submit" name="Delete" value="Delete" title="Delete" class="btn btn-danger" disabled>
                                </form>
                            <?php else:?>
                                <form action="delete.php" method="post">
                                    <input type="hidden" name="deleteuserid" value="<?php print($user[$a][0]) ?>">
                                    <input type="submit" name="Delete" value="Delete" title="Delete" class="btn btn-danger">
                                </form>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
                <?php $a++;
                    endwhile;
                ?>
            </table>
        </div>
	</div>
	<footer>
		<div class="center">V. N. Karazin Kharkiv National University | Moroslin Sergey | 2019</div>
	</footer>

    <dialog id="d_login">
        <form action="auth.php" method="post" id="login_form">
            <div class="form-group">
                <label for="l_email">Email address</label>
                <input type="email" name="email" class="form-control" id="l_email" aria-describedby="emailHelp" placeholder="Enter email" onkeyup="login_valid(document.getElementById('login_form'),document.getElementById('login_button'))" required>
            </div>
            <div class="form-group">
                <label for="l_password">Password</label>
                <input type="password" name="password" class="form-control" id="l_password" placeholder="Password" onkeyup="login_valid(document.getElementById('login_form'),document.getElementById('login_button'))" required>
            </div>
            <input id="login_button" type="submit" class="btn btn-warning" value="Fill The Form" disabled="">
            <button id="close_login" class="btn btn-danger">Close</button>
        </form>
    </dialog>

    <dialog id="d_registration">
        <form action="registration.php" method="post" id="registration">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="fname" id="first_name" aria-describedby="emailHelp" placeholder="Enter First Name" onkeyup="registration_valid(document.getElementById('registration'),document.getElementById('registration_button'))" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="lname" id="last_name" aria-describedby="emailHelp" placeholder="Enter Last Name" onkeyup="registration_valid(document.getElementById('registration'),document.getElementById('registration_button'))" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter E-Mail" onkeyup="registration_valid(document.getElementById('registration'),document.getElementById('registration_button'))" required>
            </div>
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" name="login" id="login" aria-describedby="emailHelp" placeholder="Enter Login" onkeyup="registration_valid(document.getElementById('registration'),document.getElementById('registration_button'))" required>
            </div>
            <div class="form-group">
                <label for="reg_password">Password</label>
                <input type="password" class="form-control" name="psw" id="reg_password" placeholder="Enter Password" minlength="6" required>
                <small class="form-text text-muted">Min-lenth password 6 simbols</small>
            </div>
            <div class="form-group">
                <label for="reg_re_password">Re Password</label>
                <input type="password" class="form-control" name="r_psw" id="reg_re_password" placeholder="Enter Password Again" minlength="6" onkeyup="registration_valid(document.getElementById('registration'),document.getElementById('registration_button'))" required>
            </div>
            <div class="form-group">
                <label for="role">Change Role</label>
                    <select class="custom-select custom-select-sm" name="role">
                        <option value="1">User</option>
                        <option value="2">Admin</option>
                    </select>
            </div>
            <input id="registration_button" type="submit" class="btn btn-warning" value="Fill The Form" disabled="">
            <button id="close_registration" class="btn btn-danger">Close</button>
        </form>
    </dialog>

</body>
</html>