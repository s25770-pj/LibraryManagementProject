<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wypożycz Książkę</title>

</head>
<body>

<?php

require_once "connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_errno) {
    exit("Błąd połączenia z bazą danych: " . $polaczenie->connect_errno);
}

$query = "SELECT * FROM inwentarz";
$result = $polaczenie->query($query);

if ($result->num_rows > 0) {
    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>';
        echo '<strong>Tytuł:</strong> ' . $row['tytul'] . '<br />';
        echo '<strong>Autor:</strong> ' . $row['autor'] . '<br />';
        echo '<strong>Gatunek:</strong> ' . $row['gatunek'] . '<br />';
        echo '<strong>Rodzaj:</strong> ' . $row['rodzaj'] . '<br />';
        echo '<strong>Cena:</strong> ' . $row['cena'] . '<br />';
        echo '<strong>Opis:</strong> ' . $row['opis'] . '<br />';
        echo '<form>';
        echo '<input type = "hidden" name = "book_id" value = "' . $row ['id'] . '">';
        echo '<input type = "button" name = "wypozycz" value = "Wypożycz"';
        echo '</form>';
        echo '</li>';
        echo '<br />';
    }
    echo '</ul>';
    echo '<p>[ <a href="userpanel.php">Powrót</a> ]</p>';
} else {
    echo 'Brak książek w bazie danych.';
}

$polaczenie->close();

?>

</body>
</html>