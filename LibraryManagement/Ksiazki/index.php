<?php

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Księgarnia internetowa</title>

    <script src="../JS/wyszukiwarka.js"></script>
	<link rel="stylesheet" href="../Style/style.css">
</head>

<body>
<div class = 'body'>

<div class = 'banner'>

<?php 

require_once "../Laczenie_Z_Baza/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}

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

    $id = $_SESSION['id'];
    $jakie_saldo = "SELECT saldo FROM portfele WHERE id_uzytkownika = '$id'";
    $rezultat = $polaczenie->query($jakie_saldo);

    if($rezultat) {

        if($rezultat->num_rows > 0 ) {
        $row = $rezultat->fetch_assoc();
        $_SESSION['saldo'] = $row['saldo'];

    }
}

        //Przejście do portfela
        $saldo = $_SESSION['saldo'];
		echo '<p>[ <a href="../Panel_Uzytkownika/panel_uzytkownika.php">Profil</a> ]</p>';
        echo '<p>[ <a href="../Panel_Uzytkownika/doladuj_saldo.php">' . $saldo . 'zł</a> ]</p>';

	}

?>

</div> <!-- banner -->

<div class = 'pod_bannerem'>

<div class = 'lewa'>

</div> <!-- lewa -->

<div class = 'srodek'>

<div class = 'wyszukiwanie'>

<label for="jakiGatunek"></label>
<select id="jakiGatunek" oninput="searchBooks()" class = "wyszukaj_gatunek">
    <option value="" selected>Wszystkie gatunki</option>
    <option value="Thriller">Thriller</option>
    <option value="Fantastyka">Fantastyka</option>
    <option value="Akcja">Akcja</option>
    <option value="Romans">Romans</option>
</select>

<input type="text" id="znajdzFraze" placeholder="Wyszukaj książkę lub autora" oninput="searchBooks()" class="wyszukaj_tekst">

</div>

<div id='bookResults'></div>

<?php

$polaczenie->close();

?> 
	
	<br /><br />
<?php


	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>
</div> <!--srodek-->
             <div class = "prawa">
             </div> <!--prawa-->  
</div> <!-- podbannerem-->
</div> <!-- body -->

</body>
</html>