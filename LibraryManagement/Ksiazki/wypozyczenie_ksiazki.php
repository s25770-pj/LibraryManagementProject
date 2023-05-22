<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

if((isset($_POST['id_ksiazki'])) && (isset($_POST['cena_ksiazki']))){

    require_once '../Laczenie_Z_Baza/connect.php';

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}

$id = $_SESSION['id'];
$ksiazkaid = $_POST['id_ksiazki'];

//Pobranie salda uzytkownika z bazy

$jakieSaldo = ("SELECT * FROM portfele WHERE id_uzytkownika = '$id'");
$rezultat = $polaczenie->query($jakieSaldo);

while($row = $rezultat->fetch_assoc()){

    $cena = $_POST['cena_ksiazki'];
    $saldo = $row['saldo'];
    $noweSaldo = $saldo - $cena;

    //Zmiana salda na te po zakupie
    
    $ustawNoweSaldo = ("UPDATE portfele SET saldo = ? WHERE id_uzytkownika = ?");
    $rez = $polaczenie->prepare($ustawNoweSaldo);
    
    if($rez) {

        $rez->bind_param("di", $noweSaldo, $id);
        $rez->execute();

        if($rez->affected_rows > 0) {

            echo 'Dane zostaly wstawione poprawnie';

        } else {

            echo 'Dane nie zostaly wstawione poprawnie';

        }

        echo '<div class = "wypozycz">';
        echo '<form action = "index.php" method = "POST">';
        echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">';
        echo '<input type = "hidden" name = "cena_ksiazki" value ="' . $cena . '">';
        echo '<input type = "submit" name = "wypozycz" value = "Powrót">';
        echo '</form>';

        $rez->close();

    } else {
        echo "Błąd przygotowania zapytania: " . $polaczenie->error;
    }

    //Wstawianie nowego wypożyczenia do bazy

    $noweWypozyczenie = ("INSERT INTO wypozyczenia (id_uzytkownika, id_ksiazki, data_wypozyczenia, data_zwrotu) VALUES (?, ?, ?, ?)");
    $result = $polaczenie->prepare($noweWypozyczenie);

    $dataCzas = date('Y-m-d H:i:s');
    $nowaDataCzas = date('Y-m-d H:i:s', strtotime('+7 days'));

    if ($result) {
        $result->bind_param("iiss", $id, $ksiazkaid, $dataCzas, $nowaDataCzas);
        $result->execute();

        if ($result->affected_rows > 0) {
            echo 'Dane zostały wstawione poprawnie.';
        } else {
            echo 'Błąd podczas wstawiania danych.';
        }
    }

    //Wstawienie nowej transakcji do bazy

    $nowaTransakcja = ("INSERT INTO transakcje (id_portfela, rodzaj_transakcji, kwota, data_czas) VALUES (?, ?, ?, ?)");
    $res = $polaczenie->prepare($nowaTransakcja);

    if ($res) {

        $idPortfela = $row['id'];
        $zakup = "Zakup";
        $cenaKsiazki = $_POST['cena_ksiazki'];
        $dataCzas = date('Y-m-d H:i:s');

        $res->bind_param("isds", $idPortfela, $zakup, $cenaKsiazki, $dataCzas);
        $res->execute();

        if($res->affected_rows > 0) {
            echo 'Dane zostały wstawione poprawnie.';
        } else {
            echo 'Błąd podczas wstawiania danych.';
        }
    }

    $result->close();
    $res->close();
    }

    $rezultat->close();
    $polaczenie->close();

    header('Location: index.php');

}


?>