<?php

require_once "../Includes/path.php";
require_once $database;

$patern ='/[^a-zA-ZąćżńóźęĆŻŃÓŹĘ0-9 ]/';

$phrase = isset($_POST['phrase']) ? $_POST['phrase'] : null;
$phrase = preg_replace($patern,'',htmlspecialchars($phrase));

$category = isset($_POST['category']) ? $_POST['category'] : null;
$category =  preg_replace($patern,'',htmlspecialchars($category));
if(isset($_POST['phrase']) && !empty($_POST['phrase']))
{
  $phrase = $_POST['phrase'] == $phrase ? $phrase : NULL;
  if($phrase == NULL){echo '<p> Brak książek pasujących do wyszukiwanej frazy. </p>';exit();}
}

if($phrase && $category)
{
  $query = "SELECT stock.* FROM stock INNER JOIN category ON stock.category = category.id WHERE (title LIKE '%$phrase%' OR author LIKE '%$phrase%') AND name = '$category'";
}
else if($phrase)
{
  $query = "SELECT stock.*  FROM stock WHERE title LIKE '%$phrase%' OR author LIKE '%$phrase%'";
}
else if($category)
{
  $query = "SELECT stock.* FROM stock INNER JOIN category ON stock.category = category.id WHERE name = '$category'";
}
else if($phrase == '')
{
  $query = "SELECT * FROM stock";
}
else {
  echo '<p> Brak książek pasujących do wyszukiwanej frazy. </p>';
  exit();
}
$result = $connection->query($query);

if ($result->num_rows > 0) {

    echo '<ul>';

    while ($row = $result->fetch_assoc()) {

      echo '<li class="book-item">';

      $book_id = $row['id'];

      echo "<a href = '$book_details?book_id=$book_id'>";

      $cover = $images."/".$row ['cover'] . 'r.jpg';

      echo '<img src="' . $cover . '" alt="Book cover"> <br>';
      echo '</a>';
      echo '<div>';
      echo "<p>".$row['title'] . '</p>';
      echo "<p>".$row['author'] . '</p>';
      echo '</div>';
      echo '</li>';

    }

    echo '</ul>';

  } else {

    echo '<p> Brak książek pasujących do wyszukiwanej frazy. </p>';

  }

$connection->close();

?>
