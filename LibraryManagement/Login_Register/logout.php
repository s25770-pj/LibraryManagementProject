<?php

require_once '../path.php';

	session_start();
	
	session_unset();
	
	header('Location: '.$local);

?>