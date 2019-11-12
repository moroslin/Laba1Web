<?php
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['psw'];
    $r_password = $_POST['r_psw'];
    $role = $_POST['role'];

    if ($password == $r_password) {
        $mysql = new mysqli('localhost','root','','db_1');
        $mysql->query("INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `login`, `password`, `photo`, `role_id`) VALUES ('','$first_name','$last_name','$email', '$login', '$password','',$role)");
        $mysql->close();
        header('Location: /laba1/index.php');
    } else {
        echo "Пароли не совпадают";
        exit();
    }
?>