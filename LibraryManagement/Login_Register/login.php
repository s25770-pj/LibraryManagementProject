<?php

	require_once '../path.php';

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{

		header('Location: '.$local);
		exit();
	}

	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{

		echo "Error: ".$connection->connect_errno;
		
	} else {

		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	
		if ($result = $connection->query(
		sprintf("SELECT * FROM users WHERE user='%s'",
		mysqli_real_escape_string($connection,$login)))) {

			$users_count = $result->num_rows;
			if($users_count>0)
			{

				$row = $result->fetch_assoc();
				
				if (password_verify($password, $row['pass'])) {

					$_SESSION['login'] = true;
					$_SESSION['id'] = $row['id'];
					$_SESSION['user'] = $row['user'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['premiumExpirationDate'] = $row['premiumExpirationDate'];
					$_SESSION['access'] = $row['access'];
					$_SESSION['wallet_id'] = $row['wallet_id'];
					
					unset($_SESSION['error']);

					$result->free_result();

					header('Location: '. $local);
				} else {

					$_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location:' . $panel);
					
				}
				
			} else {
				
				$_SESSION['error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location:' . $panel);
				
			}
			
		}
		
		$connection->close();
	}
	
?>