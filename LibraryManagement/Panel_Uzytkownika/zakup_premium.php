<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../Ksiazki/index.php');
		exit();
	}

if (isset($_POST["execute"]) && (isset($_POST['cena_pakietu']))){

    require_once "../Laczenie_Z_Baza/connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    
    if(!$polaczenie) {

        exit("Błąd połączenia z baza danych: " . mysqli_connect_error());

    }


    $id = $_SESSION['id'];

    //Sprawdzenie czy można dodać dni premium

    $query = "SELECT dnipremium FROM uzytkownicy WHERE id = ?";
    $rezultat = $polaczenie->prepare($query);
    $rezultat->bind_param("i", $id);
    $rezultat->execute();
    $rezultat->store_result();
    $rezultat->bind_result($dnipremium);

    if($rezultat->fetch()){

    $aktualnaDataCzas = new DateTime($dnipremium);
    $aktualnaDataCzas->modify('+ 15 days');
    $nowaDataCzas = $aktualnaDataCzas->format('Y-m-d H:i:s');

    $dzis = new DateTime();

    if ($aktualnaDataCzas > $dzis) {

        $nowaDataCzas = $aktualnaDataCzas->format('Y-m-d H:i:s');

        $updateQuery = ("UPDATE uzytkownicy SET dnipremium = ? WHERE id = ?");
        $updateRezultat = $polaczenie->prepare($updateQuery);
        $updateRezultat->bind_param("si", $nowaDataCzas, $id);

        if($updateRezultat->execute()) {

            header('Location: pakiety_premium.php');

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $updateRezultat->error;

        }

        $updateRezultat->close();

        $portfelId = $_SESSION['id_portfela'];
        $cenaPakietu = $_POST['cena_pakietu'];
        $saldo = $_SESSION['saldo'];
        $noweSaldo = $saldo - $cenaPakietu;

        $minusSaldo = ("UPDATE portfele SET saldo = ? WHERE id = ?");
        $rez = $polaczenie->prepare($minusSaldo);
        $rez->bind_param("di", $noweSaldo, $portfelId);

        if($rez->execute()) {

            $rez->execute();

            header('Location: pakiety_premium.php');

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $updateRezultat->error;

        }

    } else {

        $nowaDataCzas = $dzis->format('Y-m-d H:i:s');

        $updateQuery = "UPDATE uzytkownicy SET dnipremium = ? WHERE id = ?";
        $updateRezultat = $polaczenie->prepare($updateQuery);
        $updateRezultat->bind_param("si", $nowaDataCzas, $id);

        if($updateRezultat->execute()) {

            header('Location: pakiety_premium.php');

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $updateRezultat->error;

        }

        $portfelId = $_SESSION['id_portfela'];
        $cenaPakietu = $_POST['cena_pakietu'];
        $saldo = $_SESSION['saldo'];
        $noweSaldo = $saldo - $cenaPakietu;

        $minusSaldo = ("UPDATE portfele SET saldo = ? WHERE id = ?");
        $rez = $polaczenie->prepare($minusSaldo);
        $rez->bind_param("di", $noweSaldo, $portfelId);

        if($rez->execute()) {

            header('Location: pakiety_premium.php');

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $updateRezultat->error;

        }

        $updateRezultat->close();

    }

    $updateRezultat->close();
    $rez->close();
    $rezultat->close();

    }

    $polaczenie->close();

    unset($_POST["execute"]);
} else {
    header('Location: pakiety_premium.php');
}
?>