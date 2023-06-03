<?php

require_once "../Includes/path.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno) {

    exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);

}

//searching książki po wpisanej frazie
if (isset($_GET['phrase']) && !empty($_GET['phrase']) && empty($_GET['category'])) {

    $phrase = $_GET['phrase'];
    $category = $_GET['category'];
    $query = "SELECT * FROM stock WHERE title LIKE '%$phrase%' OR author LIKE '%$phrase%'";

//Po podanej frazie i gatunku
} else if (isset($_GET['phrase']) && !empty($_GET['phrase']) && !empty($_GET['category'])) {
    
    $phrase = $_GET['phrase'];
    $category = $_GET['category'];
    $query = "SELECT * FROM stock WHERE (title LIKE '%$phrase%' OR author LIKE '%$phrase%') AND category = '$category'";

//Po podanym gatunku
} else if (isset($_GET['category']) && !empty($_GET['category'])){ 

    $phrase = '';
    $category = $_GET['category'];
    $query = "SELECT * FROM stock WHERE category = '$category'";

//Kiedy nie podano ani frazy, ani gatunku
} else {

    $phrase = '';
    $category = '';
    $query = "SELECT * FROM stock";
}
$result = $connection->query($query);

if ($result->num_rows > 0 || empty($phrase) || empty($category)) {

    echo '<ul>';

    while ($row = $result->fetch_assoc()) {

      echo '<li class="book-item">';

      $book_id = $row['id'];

      echo "<a href = '$book_details?book_id=$book_id'>";

      $cover = $images."/".$row ['cover'] . '.jpg';

      echo '<img src="' . $cover . '" alt="Book cover"> <br />';
      echo '</a>';

      echo $row['title'] . '<br />';
      echo $row['author'] . '<br />';

      echo '</li>';

    }

    echo '</ul>';

  } else {

    echo 'Brak książek pasujących do wyszukiwanej frazy.';

  }

$connection->close();

?>
