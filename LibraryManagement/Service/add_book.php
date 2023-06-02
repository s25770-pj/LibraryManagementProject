<?php

require_once '../path.php';

session_start();

if (!isset($_SESSION['login']))
{

	header('Location: ' . $local);
	exit();

}

?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Panel Administratora</title>
    <link rel="stylesheet" href="../Style/idn.css">

</head>
<body>

<div id = "background"></div>

    <div id = "packets">

        <p><strong>Dodaj książkę do oferty księgarni: </strong></p>

        <form method = "POST">

        Tytuł: <input type = "text" name = "title" class = "add_book"> <br /><br />
        Autor: <input type = "text" name = "author" class = "add_book"> <br /><br />
        category: <input type = "text" name = "category" class = "add_book"> <br /><br />

        type: <select name = "type" class = "add_book">
        <option value = "book"> book </option>
        <option value = "Audio Book"> Audio Book </option>
        </select><br /><br />

        Cena: <input type = "number" id = "no-spinners" name = "price" class = "add_book"> <br /><br />
        description: <br /> <textarea name="description" cols="35" rows="5" class = "add_book">Tu wpisz tekst który pojawi się domyślnie</textarea> <br />

        <input type = "submit" value = "Add_book" class = "button"> <br /><br />

        </form>

        <form action = "<?php $upanel ?>">
        <input type = "submit" name = "retreat" value = "Powrót" class = "button">
        
    </form>

    <?php
    if(isset($_POST['type'])){

    $button_out  = $_POST['type'];

    }

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno) {
        exit("Błąd połączenia z bazą danych: ". $connection->connect_errno);
    }

    if(isset($_POST['type'])) {
        
        //Ustawianie id w bazie danych po ilosci recordow

        $book_id = "SELECT COUNT(*) as total FROM stock";
        $res = $connection->query($book_id);
        $row = $res->fetch_assoc();
        $totalRecords = $row['total'];

        $id = $totalRecords + 1;
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        
        //Sprawdzenie, czy isnieje book o takiej nazwie

        $query = "SELECT * FROM stock WHERE title = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            echo "Książka już istnieje w bazie danych.";

        } else {

            //Dodanie książki do księgarni

            if (empty($title) || empty($author) || empty($category) || empty($type) || empty($price) || empty($description)) {
                    echo "Wszystkie pola formularza są wymagane.";
            } else {

            $insertQuery = "INSERT INTO stock (id, title, author, category, type, price, description) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $connection->prepare($insertQuery);
            $insertStmt->bind_param("ssssss", $title, $author, $category, $type, $price, $description);

            if($insertStmt->execute()) {
                echo "Książka została dodana do oferty księgarni.";
            } else {
                echo "Błąd zapytania: " . $connection->error;
            }

            $insertStmt->close();

            }

        $stmt->close();
        
        }
    }

    $connection->close();

    ?>

    </form>

</div>

</body>

</html>