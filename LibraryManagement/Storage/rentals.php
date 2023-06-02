<?php

require_once '../path.php';

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location:'. $local);
		exit();
	}

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno) {

        exit("Bład połączenia z bazą danych: ". $connection->connect_errno);

    }

    $userID = $_SESSION['id'];

    $query = "SELECT stock.title, stock.author, stock.category, rentals.rent_date, rentals.return_date
    FROM rentals INNER JOIN stock ON rentals.book_id = stock.id WHERE rentals.user_id = $userID";

    $result = $connection->query($query);

    if($result->num_rows > 0) {
        echo "<h2> Lista wypożyczonych ksiazek: </h2>";
        echo "<ul>";

        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>title:</strong> ". $row['title'] . "</li>";
            echo "<li><strong>author:</strong> " . $row['author'] . "</li>";
            echo "<li><strong>category:</strong> " . $row['category'] . "</li>";
            echo "<li><strong>Data rentenia:</strong> " . $row['rent_date'] . "</li>";
            echo "<li><strong>Data zwrotu:</strong> " . $row['return_date'] . "</li>";
            echo "<br>";
        }

        echo "</ul>";
    } else {
        echo "Brak rentonych ksiazek dla tego uzytkownika.";
    }
    echo '[ <a href='. $panel .'>Powrót</a> ]</p>';

    $connection->close();

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