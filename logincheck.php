<?php

if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] == "loggedin"){
	header("Location:menu.php");
}