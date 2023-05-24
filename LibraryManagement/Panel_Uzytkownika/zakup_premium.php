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
    $rezultatPremium = $polaczenie->prepare($query);
    $rezultatPremium->bind_param("i", $id);
    $rezultatPremium->execute();
    $rezultatPremium->store_result();
    $rezultatPremium->bind_result($dnipremium);

    if($rezultatPremium->fetch()){

    $aktualnaDataCzas = new DateTime($dnipremium);
    $aktualnaDataCzas->modify('+ 15 days');
    $nowaDataCzas = $aktualnaDataCzas->format('Y-m-d H:i:s');

    $dzis = new DateTime();

    $jakieSaldo = "SELECT saldo FROM portfele WHERE id_uzytkownika = ? ";
    $rezultatSaldo = $polaczenie->prepare($jakieSaldo);
    $rezultatSaldo->bind_param("i", $id);
    $rezultatSaldo->execute();
    $rezultatSaldo->store_result();
    $rezultatSaldo->bind_result($saldo);

    if ($rezultatSaldo->fetch()) {

    echo 'Saldo: ' . $saldo;

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
        $noweSaldo = $saldo - $cenaPakietu;

        echo 'Cena pakietu: ' . $cenaPakietu;
        echo 'Nowe saldo: ' . $noweSaldo;

        $minusSaldo = ("UPDATE portfele SET saldo = ? WHERE id = ?");
        $rezultatNoweSaldo = $polaczenie->prepare($minusSaldo);
        $rezultatNoweSaldo->bind_param("di", $noweSaldo, $portfelId);

        if($rezultatNoweSaldo->execute()) {

            $rezultatNoweSaldo->execute();

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
        $rezultatNoweSaldo = $polaczenie->prepare($minusSaldo);
        $rezultatNoweSaldo->bind_param("di", $noweSaldo, $portfelId);

        if($rezultatNoweSaldo->execute()) {

            header('Location: pakiety_premium.php');

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $updateRezultat->error;

        }

        $updateRezultat->close();

    }

    $rezultatSaldo->close();
    $rezultatNoweSaldo->close();
    $rezultatPremium->close();

    }

    $polaczenie->close();

    unset($_POST["execute"]);
} else {
    echo 'Błąd podcas pobierania salda użytkownika.';
}
} else {
    header('Location: pakiety_premium.php');
}
?>