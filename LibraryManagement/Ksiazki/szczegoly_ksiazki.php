<?php

session_start();

if(isset($_GET['id'])){

?>

<link rel="stylesheet" href="../Style/style.css">

<div class = "duzy-banner">

    <div class = "banner">

        <?php 

            if ((!isset($_SESSION['zalogowany']))) {

        //przyciski logowania i rejestracji
        
        echo '<div id = "logowanie">';
            echo '<p>[ <a class = "p" href="../Logowanie_Rejestracja/panel_logowania.php">Logowanie</a> ]</p>';
        echo '</div>'; 
            
        echo '<div id = "rejestracja">';
            echo '<p>[ <a href="../Logowanie_Rejestracja/rejestracja.php">Rejestracja</a> ]</p>';
        echo '</div>'; 

        } else {

        require_once '../Laczenie_Z_Baza/connect.php';

        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if ($polaczenie->connect_errno) {
            exit("Błąd połączenia z bazą danych: " .$polaczenie->connect_errno);
        }

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
        echo '<div id = "koszykArr">';

            echo '<div id = "koszyk">';
            echo '<img src="cart.png">';
            echo 'Koszyk';
            echo '</div>'; 

        echo '</div>'; 

        echo '<div class = "menu">';

            echo '<form action = "../Panel_Uzytkownika/panel_uzytkownika.php">';
            echo '<input type = "submit" value = "Profil">';
            echo '</form>';

        echo '</div>';

        $saldo = number_format($saldo, 2, ',', ' ') . " zł";

        echo '<div class = "menu">';

            echo '<form action = "../Panel_Uzytkownika/doladuj_saldo.php">';
            echo '<input type = "submit" value = "'. $saldo .'">';
            echo '</form>';

        echo '</div>';

        }

        ?>

    </div> 

</div>

<div class = "pod_bannerem">


<div class = 'lewa'>

</div> <!-- lewa -->

<div class = 'srodek'>

    <?php

    require_once '../Laczenie_Z_Baza/connect.php';

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_errno) {
        exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
    }

    $ksiazkaid = $_GET['id'];

    $query = "SELECT * FROM inwentarz WHERE id = $ksiazkaid ";

    $rezultat = $polaczenie->query($query);

    if ($rezultat->num_rows > 0) {

        while ($row = $rezultat->fetch_assoc()) {

            echo '<div class = "zdjecie">';
            $okladka = $row ['okladka'] . 'r.jpg';
            echo '<img src="../Okladki/' . $okladka . '" alt="Okładka książki">';
            echo '</div>'; 

            echo '<div class = "info">';
                echo '<table>';
                echo '<tr><td> ID: </td><td>' . $row['id'] . '</td></tr><br />';
                echo '<tr><td> Rodzaj: </td><td>' . $row['rodzaj'] . '</td></tr><br />';
                echo '<tr><td>Tytuł: </td><td>' . $row['tytul'] . '</td></tr><br />'; 
                echo '<tr><td>Autor: </td><td>' . $row['autor'] . '</td></tr><br />';
                echo '<tr><td>Gatunek: </td><td>' . $row['gatunek'] . '</td></tr><br />';
                echo '<tr><td>Cena: </td><td>' . $row['cena'] . ' zł</td></tr><br />';
                echo '</table>';
            echo '</div>'; //info

            echo '<div id = "opis">';
                echo '<table>';
                echo '<tr><td></td><td>' . $row['opis'] . '</td></tr><br />';
                echo '</table>';
            echo '</div>'; //opis

            $cena = $row['cena'];
            $ksiazkaid = $row['id'];
            $data_konca = date('Y-m-d H:i:s');
            $id_uzytkownika = $_SESSION['id'];

            $czywypozyczona = "SELECT * FROM wypozyczenia WHERE id_uzytkownika = ? AND id_ksiazki = ? AND data_zwrotu > ?";
            $querySelect = $polaczenie->prepare($czywypozyczona);
            $querySelect->bind_param("iis", $id_uzytkownika, $ksiazkaid, $data_konca);
            $querySelect->execute();
            $rez = $querySelect->get_result();

            if(($_SESSION['saldo'] >= $row['cena']) && ($rez->num_rows < 1 )){

            //Sprawdzenie czy uzytkownik ma wystarczające saldo

            echo '<div class = "wypozycz">';
            echo '<form action = "wypozyczenie_ksiazki.php" method = "POST">';
            echo '<input type = "hidden" name = "id_ksiazki" value ="' . $row['id'] . '">';
            echo '<input type = "hidden" name = "cena_ksiazki" value ="' . $cena . '">';
            echo '<input type = "submit" name = "wypozycz" value = "Wypożycz" class = "przycisk">';
            echo '</form>';
            } else if(($rez->num_rows > 0 )) {

                //Sprawdzenie czy uzytkownik już wypożyczył tą książkę

                echo '<div class = "wypozycz">';
                echo '<form action = "../Panel_Uzytkownika/wypozyczenia.php" method = "GET">';
                echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">';
                echo '<input type = "hidden" name = "cena_ksiazki" value ="' . $row['cena'] . '">';
                echo '<input type = "submit" name = "wypozyczona" value = "Książka została już przez Ciebie wypożyczona" class = "przycisk">';
                echo '</form>';

            } else {

                echo '<div class = "wypozycz">';
                    echo '<form action = "../Panel_Uzytkownika/wypozyczenia.php" method = "GET">';
                    echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">';
                    echo '<input type = "hidden" name = "cena_ksiazki" value ="' . $row['cena'] . '">';
                    echo '<input type = "submit" name = "doladuj" value = "Doładuj saldo" class = "przycisk">';
                    echo '</form>';
                }

                echo '<form action = "index.php">';
                echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';
                echo '</form>';

                echo '</div>'; //wypozycz 

            echo '</div>'; //srodek

        echo '<div class = "prawa">';

        echo '</div>'; //prawa 

    echo '</div>'; //podbannerem

            $rez->close();

        }
    }
    $rezultat->close();
    $polaczenie->close();

} else {

    echo 'Brak przesłanego ID książki.';

}

?>
