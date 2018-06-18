<?php
session_start();
$_SESSION['is_logged_in'] = "logout";

header("Location:index.php");
 exit(0);