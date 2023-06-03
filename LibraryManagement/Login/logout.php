<?php

require_once '../Includes/path.php';

	session_start();
	
	session_unset();
	
	header('Location: '.$index);

?>