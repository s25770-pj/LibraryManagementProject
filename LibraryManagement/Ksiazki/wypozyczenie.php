<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}


require_once '../Laczenie_Z_Baza/connect.php';

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$id_uzytkownika = $_SESSION['id'];
$id_ksiazki = $_GET['id_ksiazki'];
$data_konca = date('Y-m-d H:i:s');

//Sprawdzenie czy książka została wypożyczona

$czywypozyczona = "SELECT * FROM wypozyczenia WHERE id_uzytkownika = ? AND id_ksiazki = ? AND data_zwrotu > ?";
$prep = $polaczenie->prepare($czywypozyczona);
$prep->bind_param("iis", $id_uzytkownika, $id_ksiazki, $data_konca);
$prep->execute();
$rez = $prep->get_result();

if($rez->num_rows > 0 ) {

    echo "Książka została już przez ciebie wypożyczona";

} else {

if ($polaczenie->connect_errno) {
    echo "Błąd połączenia z bazą danych: " . $polaczenie->connect_error;
    exit();
}

if(isset($_GET['id_ksiazki'])){

    $id_uzytkownika = $_SESSION['id'];
    $aktualna_data_czas = date('Y-m-d H:i:s');

    echo 'id ksiazki: ' . $id_ksiazki . '<br />';
    echo 'Aktualna data: ' . $aktualna_data_czas . '<br />';

        //Dodanie wypożyczenia do bazy danych
        
        $query = "INSERT INTO wypozyczenia VALUES (NULL ,? ,? ,now() , now() + INTERVAL 7 DAY)";

        $stmt = $polaczenie->prepare($query);
        $stmt->bind_param("ii", $id_uzytkownika, $id_ksiazki);

    if ($stmt->execute()) {

        echo "Rekord został dodany do bazy poprawnie. <br />";

    } else {

        echo "Błąd podczas dodawania rekordu do bazy danych. <br />";

    }

}
$rez->close();

$stmt->close();

$polaczenie->close();

}

?>