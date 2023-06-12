<?php

require_once "../Includes/path.php";
require_once $database;

//searching książki po wpisanej frazie
if (isset($_POST['phrase']) && !empty($_POST['phrase']) && empty($_POST['category'])) {

    $phrase = $_POST['phrase'];
    $phrase = urlencode($phrase);
    $category = $_POST['category'];
    $query = "SELECT * FROM stock WHERE title LIKE '%$phrase%' OR author LIKE '%$phrase%'";

//Po podanej frazie i gatunku
} else if (isset($_POST['phrase']) && !empty($_POST['phrase']) && !empty($_GET['category'])) {
    
    $phrase = $_POST['phrase'];
    $phrase = urlencode($phrase);
    $category = $_POST['category'];
    $query = "SELECT * FROM stock WHERE (title LIKE '%$phrase%' OR author LIKE '%$phrase%') AND category = '$category'";

//Po podanym gatunku
} else if (isset($_POST['category']) && !empty($_POST['category'])){ 

    $phrase = '';
    $phrase = urlencode($phrase);
    $category = $_POST['category'];
    $query = "SELECT * FROM stock WHERE category = '$category'";

//Kiedy nie podano ani frazy, ani gatunku
} else {

    $phrase = '';
    $phrase = urlencode($phrase);
    $category = '';
    $query = "SELECT * FROM stock";
}
$result = $connection->query($query);

if ($result->num_rows > 0) {

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

    echo '<p> Brak książek pasujących do wyszukiwanej frazy. </p>';

  }

$connection->close();

?>
