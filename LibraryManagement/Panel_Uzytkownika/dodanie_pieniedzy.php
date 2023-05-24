<link rel="stylesheet" href="../Style/dodanie_pieniedzy.css">

<?php

session_start();

if (!isset($_SESSION['zalogowany']))
{
	header('Location: index.php');
	exit();
}

if(isset($_POST['kwota_doladowania'])){

require_once '../Laczenie_Z_Baza/connect.php';

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {

    exit("Błąd połączenia z bazą danych: ". $polaczenie->connect_errno);

}

$id = $_SESSION['id'];

$query = ("SELECT saldo FROM portfele WHERE id_uzytkownika = '$id'");
$rezultat = $polaczenie->query($query);

while($row = $rezultat->fetch_assoc()) {

$saldo = $row['saldo'];
$kwotaDoladowania = $_POST['kwota_doladowania'];

$noweSaldo = $saldo + $kwotaDoladowania;

$queryUpdate = ("UPDATE portfele SET saldo = '$noweSaldo' WHERE id_uzytkownika = '$id'");
$rez = $polaczenie->query($queryUpdate);

if($rez) {

    if(isset($_POST['id_ksiazki'])){

    $ksiazkaid = $_POST['id_ksiazki'];

    echo "<br /> Dane zostały zaktualizowane poprawnie.";

    echo '<div class = powrot>';
    echo '<form action = "../Ksiazki/szczegoly_ksiazki.php" method = "GET">';
    echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">';
    echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';

    echo '</form>';
    echo '</div>';

    } else {
        header('Location: ../Panel_Uzytkownika/doladuj_saldo.php');
    }

} else {
    echo "Błąd podczas aktualizacji danych: " . $polaczenie->error;
}

}

$rezultat->close();

$polaczenie->close();

}


?>