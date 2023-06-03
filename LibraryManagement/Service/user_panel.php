<?php

	session_start();

	require_once "../Includes/path.php";
	
	if (!isset($_SESSION['login']))
	{

		header('Location: $index');
		exit();

	}

	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>

<meta charset="utf-8" />
<title>Księgarnia internetowa</title>

</head>

<body>
	
<?php

$date_time = new DateTime(date('Y-m-d H:i:s'));

$end = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['premiumExpirationDate']);

$difference = $date_time->diff($end);

if($date_time<$end) {
	echo "Pakiet premium aktywny do: <br />" . $_SESSION['premiumExpirationDate'];
} else {
	echo "Premium nieaktywne.";
}

	echo "<p>Witaj ".$_SESSION['user'].'! [ <a href='. $logout .'>Wyloguj się!</a> ]</p>';
	echo "<p><b>E-mail</b>: ".$_SESSION['email']. "</b></p>";

	if($_SESSION['access'] == "admin"){

	echo '<p>[ <a href='. $add_book .'>Dodaj książkę</a> ]</p>';

	}
	echo '<p>[ <a href='. $rentals .'>Historia renten!</a> ]</p>';
	echo '<p>[ <a href='. $package_premium .'>Kup karnet premium</a> ]</p>';
	echo '<p>[ <a href='. $index .'>Powrót</a> ]</p>';
	
?>

</body>
</html>