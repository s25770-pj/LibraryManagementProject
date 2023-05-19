<?php

session_start();

require_once 'session_timeout.php';

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

    require_once "connect.php";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno) {
        exit("Bład połączenia z bazą danych: ". $polaczenie->connect_errno);
    }

    $userID = $_SESSION['id'];

    $query = "SELECT inwentarz.tytul, inwentarz.autor, inwentarz.gatunek, wypozyczenia.data_wypozyczenia, wypozyczenia.data_zwrotu
    FROM wypozyczenia INNER JOIN inwentarz ON wypozyczenia.id_inwentarz = inwentarz.id WHERE wypozyczenia.id_uzytkownika = $userID";

    $rezultat = $polaczenie->query($query);

    if($rezultat->num_rows > 0) {
        echo "<h2> Lista wypozyczonych ksiazek: </h2>";
        echo "<ul>";

        while ($row = $rezultat->fetch_assoc()) {
            echo "<li><strong>Tytul:</strong> ". $row['tytul'] . "</li>";
            echo "<li><strong>Autor:</strong> " . $row['autor'] . "</li>";
            echo "<li><strong>Gatunek:</strong> " . $row['gatunek'] . "</li>";
            echo "<li><strong>Data wypozyczenia:</strong> " . $row['data_wypozyczenia'] . "</li>";
            echo "<li><strong>Data zwrotu:</strong> " . $row['data_zwrotu'] . "</li>";
            echo "<br>";
            echo '[ <a href="userpanel.php">Powrót</a> ]</p>';
        }

        echo "</ul>";
    } else {
        echo "Brak wypozyczonych ksiazek dla tego uzytkownika.";
        echo '[ <a href="userpanel.php">Powrót</a> ]</p>';
    }

    $polaczenie->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>
</head>
<body>
    
</body>
</html>