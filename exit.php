<?php
    session_start();
    session_destroy();
	header('Location: /laba1/index.php');
?>