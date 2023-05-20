<?php

session_start();

?>

<link rel="stylesheet" href="../Style/style.css">

<div class = 'body'>

<div class = 'banner'>
        dfsfsdf
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

if(isset($_POST['id_ksiazki'])){
    $ksiazkaid = $_POST['id_ksiazki'];

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

            echo '<div class = "wypozycz">';
            echo '<form action = "finalizacja.php" method = "POST">';
            echo '<input type = "hidden" name = "id_transakcji" value ="' . $row['id'] . '">';
            echo '<input type = "submit" name = "wypozycz" value = "Wypożycz">';
            echo '</form>';
            echo '<p>[ <a href = "index.php"> Powrót </a> ]</p>';
            echo '</div>'; //finalizacja
            echo '</div>'; //srodek
            echo '<div class = "prawa">';
            echo 'PRAWA';
            echo '</div>'; //prawa  

        }
    }

} else {

    echo 'Brak przesłanego ID książki.';

}

$polaczenie->close();

?>
</div> <!-- podbannerem-->
</div> <!-- body -->