<?php

	session_start();
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../Ksiazki/index.php');
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

$dataczas = new DateTime(date('Y-m-d H:i:s'));

echo "Data i czas serwera: " . $dataczas->format('Y-m-d H:i:s') . "<br>";

$koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);

$roznica = $dataczas->diff($koniec);

if($dataczas<$koniec) {
	echo "Pozostałe dni premium: " . $roznica->format('%y lat, %m, mies, %d dni, %h godz, %i min, %s sek');
} else {
	echo "Premium nieaktywne od: " . $roznica->format('%y lat, %m, mies, %d dni, %h godz, %i min, %s sek');
}
	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href="../Logowanie_Rejestracja/logout.php">Wyloguj się!</a> ]</p>';
	echo "<p><b>E-mail</b>: ".$_SESSION['email']. "</b></p>";

	if($_SESSION['dostep'] == "admin"){

	echo '<p>[ <a href="dodaj_ksiazke.php">Dodaj książkę</a> ]</p>';

	}
	echo '<p>[ <a href="wypozyczenia.php">Historia wypozyczen!</a> ]</p>';
	echo '<p>[ <a href="premium.php">Kup karnet premium</a> ]</p>';
	echo '<p>[ <a href="../Ksiazki/index.php">Powrót</a> ]</p>';
	
?>

</body>
</html>