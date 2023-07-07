<?php

require_once '../Includes/config.php';
?>
<link rel="stylesheet" href="../Style/rentals.css">
<?php 
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
    echo '<div class="h1">';
    echo '<div id="go_back">';
        echo '<button class="button_back" onclick="window.location.href=\'' . $page . '\'">Powrót do menu</button>';
    echo '</div>';
    echo "<h2>Lista wypożyczonych książek:</h2>";
    echo '</div>';
    if ($result->num_rows > 0) {
        echo "<div class='book-list'>";

        while ($row = $result->fetch_assoc()) {
            $category = $row['category'];

            $query_category = "SELECT name FROM category WHERE id = $category";

            $category_result = $connection->query($query_category);

            if ($category_result->num_rows > 0) {

                while ($row_cat = $category_result->fetch_assoc()) {
                    $id = $row['id'];
                    echo "<ul>";
                    echo "<div class='rental'>";
                    echo "<li><strong>Tytuł:</strong> " . $row['title'] . "</li>";
                    echo "<li><strong>Autor:</strong> " . $row['author'] . "</li>";
                    echo "<li><strong>Kategoria:</strong> " . $row_cat['name'] . "</li>";
                    echo "<li><strong>Data wypożyczenia:</strong> " . $row['rent_date'] . "</li>";
                    echo "<li><strong>Data zwrotu:</strong> " . $row['return_date'] . "</li>";
                    echo "<li><a href='$book_details?book_id=$id'>Szczegóły</a></li>";
                    echo "<br>";
                    echo "</div>";
                    echo "</ul>";
                }
            }
        }

        echo "</div>";
    } else {
        echo "<p class='no-books'>Brak wypożyczonych książek.</p>";
    }

    $connection->close();
?>