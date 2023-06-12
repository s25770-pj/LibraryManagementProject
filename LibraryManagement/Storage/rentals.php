<?php

require_once '../Includes/path.php';

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location:'. $page);
		exit();
	}

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno) {

        exit("Bład połączenia z bazą danych: ". $connection->connect_errno);

    }

    $userID = $_SESSION['id'];

    $query = "SELECT stock.id, stock.title, stock.author, stock.category, rentals.rent_date, rentals.return_date
    FROM rentals INNER JOIN stock ON rentals.book_id = stock.id WHERE rentals.user_id = $userID";

    $result = $connection->query($query);

    if($result->num_rows > 0) {
        echo "<h2> Lista wypożyczonych ksiazek: </h2>";
        echo "<ul>";

        while ($row = $result->fetch_assoc()) {
            $category = $row['category'];

            $query_category = "SELECT name FROM category WHERE id = $category";

            $category_result = $connection->query($query_category);

            if ($result->num_rows > 0) {

                while ($row_cat = $category_result->fetch_assoc()) {
            $id = $row['id'];
            echo "<li><strong>Tytuł:</strong> ". $row['title'] . "</li>";
            echo "<li><strong>Autor:</strong> " . $row['author'] . "</li>";
            echo "<li><strong>Kategoria:</strong> " . $row_cat['name'] . "</li>";
            echo "<li><strong>Data wypożyczenia:</strong> " . $row['rent_date'] . "</li>";
            echo "<li><strong>Data zwrotu:</strong> " . $row['return_date'] . "</li>";
            echo "<a href = '$book_details?book_id=$id'>łot</a>";
            echo "<br>";
                }
            }
        }

        echo "</ul>";
    } else {
        echo "Brak wypożyczonych ksiazek.";
    }
    echo '[ <a href='. $login_panel .'>Powrót</a> ]</p>';

    $connection->close();

?>