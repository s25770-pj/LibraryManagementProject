<?php 

require_once '../path.php';

session_start();

if (isset($_SESSION['login']))
	{
		header('Location: '.$local);
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>

    <form action= "../Login_Register/login.php" method="POST">
	
    Login: <br /> <input type="text" name="login" /> <br />
    Hasło: <br /> <input type="password" name="password" /> <br /><br />

    <input type="submit" value="Zaloguj się" />

    <?php

    echo '<p>[ <a href='. $local .'>Powrót</a> ]</p>';

    ?>

</form>
    
</body>
</html>