<?php 

if (!isset($_SESSION['logged'])) {
    header("Location: ../index.php");
    die;
}

require_once '../Config/path.php';

	session_start();
    unset($_SESSION['logged']);
	
	session_destroy();
    
    header("Location: $login_page");
	
