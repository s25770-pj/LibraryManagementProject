<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Księgarnia internetowa</title>

	<link rel="stylesheet" href="../Style/style.css">
</head>

<body>
<div class = 'body'>

<div class = 'banner'>

<?php

?>

<?php 


if ((!isset($_SESSION['zalogowany'])))

	{

	echo '<div class = "logowanie">';

	echo '<p>[ <a class = "p" href="../Logowanie_Rejestracja/panel_logowania.php">Logowanie</a> ]</p>';
		
	echo '</div>'; //logowanie

	echo '<div class = "rejestracja">';

	echo '<p>[ <a href="../Logowanie_Rejestracja/rejestracja.php">Rejestracja</a> ]</p>';

	echo '</div>'; //rejestracja

	}

	if(isset($_SESSION['zalogowany']))
	{

		echo '<p>[ <a href="../Panel_Uzytkownika/userpanel.php">Profil</a> ]</p>';


	}

?>

</div> <!-- banner -->

<div class = "pod_bannerem">

<div class = 'lewa'>
</div> <!-- lewa -->

<div class = 'srodek'>

<?php

require_once "../Laczenie_Z_Baza/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}

$query = "SELECT * FROM inwentarz";
$result = $polaczenie->query($query);

if ($result->num_rows > 0) {
    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>';
        echo '<strong>Tytuł:</strong> ' . $row['tytul'] . '<br />';
        echo '<strong>Autor:</strong> ' . $row['autor'] . '<br />';
        echo '<strong>Gatunek:</strong> ' . $row['gatunek'] . '<br />';
        echo '<strong>Rodzaj:</strong> ' . $row['rodzaj'] . '<br />';
        echo '<strong>Cena:</strong> ' . $row['cena'] . '<br />';
        echo '<form action = "szczegoly_ksiazki.php" method = "POST">';
        echo '<input type="hidden" name="id_ksiazki" value="' . $row['id'] . '">';
        echo '<input type="submit" name="szczegoly" value="Szczegóły">';
        echo '</form>';
        echo '</li>';
        echo '<br />';
    }
    echo '</ul>';
} else {
    echo 'Brak książek w bazie danych.';
}


$polaczenie->close();


?>


             </div> <!--srodek-->
             <div class = "prawa">
             </div> <!--prawa-->  

</div> <!-- podbannerem-->
</div> <!-- body -->
	
	<br /><br />
<?php


	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>

</body>
</html>