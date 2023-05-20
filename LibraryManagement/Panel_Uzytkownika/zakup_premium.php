<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../Ksiazki/index.php');
		exit();
	}

if (isset($_POST["execute"])){

    require_once "../Laczenie_Z_Baza/connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    
    if(!$polaczenie) {

        exit("Błąd połączenia z baza danych: " . mysqli_connect_error());

    }

    $id = $_SESSION['id'];

    $query = "SELECT dnipremium FROM uzytkownicy WHERE id = ?";
    $rezultat = $polaczenie->prepare($query);
    $rezultat->bind_param("i", $id);
    $rezultat->execute();
    $rezultat->bind_result($dnipremium);

    if($rezultat->fetch()){

    $aktualnaDataCzas = new DateTime($dnipremium);
    $aktualnaDataCzas->modify('+ 15 days');
    $nowaDataCzas = $aktualnaDataCzas->format('Y-m-d H:i:s');

    $rezultat->close();

    $dzis = new DateTime();

    if ($aktualnaDataCzas > $dzis) {

        $updateQuery = "UPDATE uzytkownicy SET dnipremium = ? WHERE id = ?";
        $updateRezultat = $polaczenie->prepare($updateQuery);
        $updateRezultat->bind_param("si", $nowaDataCzas, $id);

        if($updateRezultat->execute()) {

            header('Location: premium.php');

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $updateRezultat->error;

        }

        $updateRezultat->close();

    } else {

        echo "Data w bazie jest wcześniejsza niż bieżąca data.";

    }

    }

    $polaczenie->close();

    unset($_POST["execute"]);
}
?>