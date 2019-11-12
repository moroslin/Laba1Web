<?php
$mysql = new mysqli('localhost','root','','db_1');

$id = $_POST['deleteuserid'];
$mysql -> query("DELETE FROM users WHERE id = '$id'");
$mysql->close();
header("Location: index.php");
?>