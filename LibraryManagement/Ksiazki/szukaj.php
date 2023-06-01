<?php

require_once "../Laczenie_Z_Baza/connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}
//Wyszukiwanie książki po wpisanej frazie
if (isset($_GET['fraza']) && !empty($_GET['fraza']) && empty($_GET['gatunek'])) {
    $fraza = $_GET['fraza'];
    $gatunek = $_GET['gatunek'];
    $query = "SELECT * FROM inwentarz WHERE tytul LIKE '%$fraza%' OR autor LIKE '%$fraza%'";
//Po podanej frazie i gatunku
} else if (isset($_GET['fraza']) && !empty($_GET['fraza']) && !empty($_GET['gatunek'])) {
    
    $fraza = $_GET['fraza'];
    $gatunek = $_GET['gatunek'];
    $query = "SELECT * FROM inwentarz WHERE (tytul LIKE '%$fraza%' OR autor LIKE '%$fraza%') AND gatunek = '$gatunek'";
//Po podanym gatunku
}else if (isset($_GET['gatunek']) && !empty($_GET['gatunek'])){ 

    $fraza = '';
    $gatunek = $_GET['gatunek'];
    $query = "SELECT * FROM inwentarz WHERE gatunek = '$gatunek'";
//Kiedy nie podano ani frazy, ani gatunku
}else {

    $fraza = '';
    $gatunek = '';
    $query = "SELECT * FROM inwentarz";
}

$rezultat = $polaczenie->query($query);

if ($rezultat->num_rows > 0 || empty($fraza) || empty($gatunek)) {
    echo '<ul>';
    while ($row = $rezultat->fetch_assoc()) {
      echo '<li class="book-item">';
      $id = $row['id'];
      echo '<a href = "./szczegoly_ksiazki.php?id=' . $id . '">';
      $okladka = $row ['okladka'] . '.jpg';
      echo '<img src="../Okladki/' . $okladka . '" alt="Okładka książki"> <br />';
      echo '</a>';
      echo $row['tytul'] . '<br />';
      echo $row['autor'] . '<br />';

      echo '</li>';
    }
    echo '</ul>';
  } else {
    echo 'Brak książek pasujących do wyszukiwanej frazy.';
  }

$polaczenie->close();

?>
