<?php
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $mysql = new mysqli('localhost','root','','db_1');
    
    $result = $mysql->query("SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'");
    $user = $result->fetch_assoc();
    if(empty($user)) {
      echo "Такой пользователь не найден";
      exit();
    }
    $_SESSION['user'] = $user['first_name'];
    $_SESSION['iduser'] = $user['id'];
    $_SESSION['role'] = $user['role_id'];

    $mysql->close();
    header('Location: /laba1/index.php');
?>