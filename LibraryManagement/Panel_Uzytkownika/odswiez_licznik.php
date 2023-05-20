<?php

session_start();

require_once '../Laczenie_Z_Baza/connect.php';

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}

    //Pobieranie z bazy danych date konca premium
    $query = "SELECT dnipremium FROM uzytkownicy WHERE id = ? ";
    $id = $_SESSION['id'];
    $rezultat = $polaczenie->prepare($query);
    $rezultat->bind_param("i", $id);
    $rezultat->execute();
    $rezultat->bind_result($data_czas);

    if($rezultat->fetch()) {
        $aktualnaDataCzas = new DateTime();
        $bazaDataCzas = new DateTime($data_czas);
    }

// Wykonaj porównanie daty i czasu oraz wygeneruj odpowiedź
if ($aktualnaDataCzas < $bazaDataCzas) {
    $roznica = $aktualnaDataCzas->diff($bazaDataCzas);
    $pozostalyCzas = $roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s sek');
    echo "Pozostały czas pakietu premium: <br />" . $pozostalyCzas;
} else {
    echo "Pakiet premium nieaktywny.";
}

$rezultat->close();
$polaczenie->close();


?>