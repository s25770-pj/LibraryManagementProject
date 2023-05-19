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

	<style>

	a {
		text-decoration: none;
	}

	</style>

</head>

<body>
	
<?php

	echo "<p> Pozostałe dni karnetu premium: " . $_SESSION['dnipremium'];
	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="logout.php">Wyloguj się!</a> ]</p>';
	echo "<p><b>E-mail</b>: ".$_SESSION['email']. "</b></p>";

	if($_SESSION['dostep'] == "admin"){

	echo '<p>[ <a href="dodaj_ksiazke.php">Dodaj książkę</a> ]</p>';

	}
	echo '<p>[ <a href="wypozycz_ksiazke.php">Wypożycz książkę</a> ]</p>';
	echo '<p>[ <a href="wypozyczenia.php">Historia wypozyczen!</a> ]</p>';
	echo '<p>[ <a href="premium.php">Kup karnet premium</a> ]</p>';
	
	
?>

</body>
</html>