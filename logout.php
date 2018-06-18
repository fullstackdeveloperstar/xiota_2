<?php
session_start();
$_SESSION['is_logged_in'] = "logout";
$_SESSION['is_first_into'] = 'no';
header("Location:index.php");
exit(0);