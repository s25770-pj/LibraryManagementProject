<?php

session_start();

if(isset($_GET['id_ksiazki'])){

?>

<link rel="stylesheet" href="../Style/style.css">

<div class = 'body'>

<div class = 'banner'>

<?php

    $saldo = $_SESSION['saldo'];
    
    echo '<p>[ <a href="../Panel_Uzytkownika/panel_uzytkownika.php">Profil</a> ]</p>';
    echo '<p>[ <a href="../Panel_Uzytkownika/panel_uzytkownika.php">' . $saldo . 'zł</a> ]</p>';

    ?>

</div> <!-- banner -->

<div class = "pod_bannerem">

<div class = 'lewa'>
    LEWA
</div> <!-- lewa -->

<div class = 'srodek'>

<?php

require_once '../Laczenie_Z_Baza/connect.php';

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}

    $ksiazkaid = $_GET['id_ksiazki'];

    $query = "SELECT * FROM inwentarz WHERE id = $ksiazkaid ";

    $rezultat = $polaczenie->query($query);

    if ($rezultat->num_rows > 0) {

        while ($row = $rezultat->fetch_assoc()) {

            echo '<div class = "zdjecie">';
            echo '.zdjecie';
            echo '</div>'; //zdjecie

            echo '<div class = "info">';
            echo '<table>';
            echo '<tr><td> ID: </td><td>' . $row['id'] . '</td></tr><br />';
            echo '<tr><td> Rodzaj: </td><td>' . $row['rodzaj'] . '</td></tr><br />';
            echo '<tr><td>Tytuł: </td><td>' . $row['tytul'] . '</td></tr><br />'; 
            echo '<tr><td>Autor: </td><td>' . $row['autor'] . '</td></tr><br />';
            echo '<tr><td>Gatunek: </td><td>' . $row['gatunek'] . '</td></tr><br />';
            echo '<tr><td>Cena: </td><td>' . $row['cena'] . '</td></tr><br />';
            echo '</table>';
            echo '</div>'; //info

            echo '<div class = "opis">';
            echo '<table>';
            echo '<tr><td>Opis: </td><td>' . $row['opis'] . '</td></tr><br />';
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
            echo 'PRAWA';
            echo '</div>'; //prawa  
            echo '</div>'; //podbannerem
            echo '</div>'; //body

            $rez->close();

        }
    }
    $rezultat->close();
    $polaczenie->close();

} else {

    echo 'Brak przesłanego ID książki.';

}

?>
