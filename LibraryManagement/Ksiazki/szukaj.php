<?php

require_once "../Laczenie_Z_Baza/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}

if (isset($_GET['phrase']) && !empty($_GET['phrase'])) {
    $phrase = $_GET['phrase'];
    $query = "SELECT * FROM inwentarz WHERE tytul LIKE '%$phrase%' OR autor LIKE '%$phrase%'";
} else {
    $phrase = '';
    $query = "SELECT * FROM inwentarz";
}

$result = $polaczenie->query($query);

if ($result->num_rows > 0 || empty($phrase)) {
    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>';
        echo '<strong>Tytuł:</strong> ' . $row['tytul'] . '<br />';
        echo '<strong>Autor:</strong> ' . $row['autor'] . '<br />';
        echo '<strong>Gatunek:</strong> ' . $row['gatunek'] . '<br />';
        echo '<strong>Rodzaj:</strong> ' . $row['rodzaj'] . '<br />';
        echo '<strong>Cena:</strong> ' . $row['cena'] . '<br />';
        echo '<form action="szczegoly_ksiazki.php" method="GET">';
        echo '<input type="hidden" name="id_ksiazki" value="' . $row['id'] . '">';
        echo '<input type="submit" name="szczegoly" value="Szczegóły" class="przycisk">';
        echo '</form>';
        echo '</li>';
        echo '<br />';
    }
    echo '</ul>';
} else {
    echo 'Brak książek pasujących do wyszukiwanej frazy.';
}

$polaczenie->close();

?>
