<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Księgarnia internetowa</title>
</head>

<body>
	
<?php

	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
	echo "<p><b>E-mail</b>: ".$_SESSION['email']. "</b></p>";

	if($_SESSION['dostep'] == "admin"){

	echo '<p>[ <a href="adminpanel.php">Panel administratora</a> ]</p>';

	}
	echo '<p>[ <a href="wypozycz.php">Wypożyć książkę</a> ]</p>';
	echo '<p>[ <a href="wypozyczenia.php">Historia wypozyczen!</a> ]</p>';
	
	
?>

</body>
</html>