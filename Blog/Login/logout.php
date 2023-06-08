<?php 

if (!isset($_SESSION['logged'])) {
    header("Location: ../index.php");
    die;
}

require_once '../Config/path.php';

	session_start();
	
	session_unset();
    
    header("Location: $login");
	
