<?php

require_once '../Includes/path.php';

session_start();




if (!isset($_SESSION['login']) || $_SESSION['access'] == 'user')
{

	header('Location: ' . $page);
	exit();

}

?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <title>Panel Administratora</title>
    <link rel="stylesheet" href="../Style/main.css">

</head>
<body>

<div id = "background"></div>

    <div id = "packages">

        <p><strong>Dodaj książkę do oferty księgarni: </strong></p>

        <form method = "POST">

        <table>
    <tr>
      <td>Tytuł:</td>
      <td><input type="text" name="title" class="add_book"></td>
    </tr>
    <tr>
      <td>Autor:</td>
      <td><input type="text" name="author" class="add_book"></td>
    </tr>
    <tr>
      <td><label for="what_category">Kategoria:</label></td>
      <td>
        <select name="category" class="add_book">
          <option value="" selected>Wszystkie gatunki</option>
          <option value="Thriller">Thriller</option>
          <option value="Fantastyka">Fantastyka</option>
          <option value="Akcja">Akcja</option>
          <option value="Romans">Romans</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>type:</td>
      <td>
        <select name="type" class="add_book">
          <option value="book">book</option>
          <option value="Audio Book">Audio Book</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Cena:</td>
      <td><input type="number" min="1" step="0.01" id="no-spinners" name="price" class="add_book"></td>
    </tr>
  </table>
        opis:<br/><textarea name="description" style="max-height: 500px; max-width: 800px; overflow: auto;" cols="35" rows="5" class="add_book" onfocus="if(this.value==='Tu wpisz opis książki') this.value='';" onblur="if(this.value==='') this.value='Tu wpisz opis książki';">Tu wpisz opis książki</textarea><br />

        <input type = "submit" value = "Dodaj książkę" class = "button"> <br /><br />

        </form>
        <?php
        echo "<form action = '$page'>";
        ?>
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
        
        $title = $_POST['title'];
        $author = $_POST['author'];
        $category = $_POST['category'];

        $categoryFormData = "SELECT `name`,`id` FROM `category`";
        $res = $connection->query($categoryFormData);
        $isCategory=false;
        while ($row = $res->fetch_assoc())
        {
            if($row['name'] == $category)
            {
                $idCategory=$row['id'];
                $isCategory=true;
                break;
            }
        }
        if(!$isCategory)
        {
           echo "Kategoria nie istnieje.";
           exit(); 
        }
        $type = $_POST['type'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        if($_POST['price'] < 1){
            echo "Cena nie może być ujemna";
            exit();
        }

        $query = "SELECT * FROM stock WHERE title = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            echo "Książka już istnieje w bazie danych.";

        } else {

            if (empty($title) || empty($author) || empty($category) || empty($type) || empty($price) || empty($description)) {
                    echo "Wszystkie pola formularza są wymagane.";
            } else {

            $insertQuery = "INSERT INTO stock (title, author, category, type, price, description) VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $connection->prepare($insertQuery);
            $insertStmt->bind_param("ssssss", $title, $author, $idCategory, $type, $price, $description);

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