<?php

require_once "../Includes/path.php";
require_once $database;
session_start();

if(isset($_GET['book_id'])){

  ?>

  <link rel="stylesheet" href="../Style/style.css">
  <?php

  require_once "$header";
  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Strona z treścią</title>
    <style>
      .content {
        display: none;
      }
      .content:target {
        display: block;
      }
    </style>
  </head>
  </html>

  <div class = "pod_bannerem">

    <div class = 'lewa'></div> 

      <div class = 'srodek'>

        <?php
        $book_id = $_GET['book_id'];

        $query = "SELECT * FROM stock WHERE id = $book_id ";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {

          while ($row = $result->fetch_assoc()) {

            echo '<div class = "zdjecie">';

              $cover = $images."/".$row ['cover'] . 'r.jpg';

              echo "<img src='$cover' alt='Book cover'>";

            echo '</div>'; 

            echo '<div class = "info">';
              echo '<table>';
                echo '<tr><td> type: </td><td>' . $row['type'] . '</td></tr><br />';
                echo '<tr><td>Tytuł: </td><td>' . $row['title'] . '</td></tr><br />'; 
                echo '<tr><td>author: </td><td>' . $row['author'] . '</td></tr><br />';
                echo '<tr><td>category: </td><td>' . $row['category'] . '</td></tr><br />';
                echo '<tr><td>price: </td><td>' . $row['price'] . ' zł</td></tr><br />';
              echo '</table>';
            echo '</div>';

            echo '<div id = "description">';
              echo '<table>';
                echo '<tr><td></td><td>' . $row['description'] . '</td></tr><br />';
              echo '</table>';
            echo '</div>';

            $price = $row['price'];
            $book_id = $row['id'];
            $end_date = date('Y-m-d H:i:s');

            if (isset($_SESSION['login'])) {
              $user_id = $_SESSION['id'];
            }

            $is_rent = "SELECT * FROM rentals WHERE user_id = ? AND book_id = ? AND return_date > ?";

            $querySelect = $connection->prepare($is_rent);
            $querySelect->bind_param("iis", $user_id, $book_id, $end_date);
            $querySelect->execute();
            $rez = $querySelect->get_result();
                
            echo '<div class = "rent">';

              if((isset($_SESSION['balance']) && $_SESSION['balance'] >= $row['price']) && ($rez->num_rows < 1 )){
                $rent_book_url = htmlspecialchars($rent_book) . '?book_id=' . urlencode($book_id);
                $book_price_value = htmlspecialchars($price);

                echo "<form action = '$rent_book_url' method = 'POST'>";
                  echo '<input type = "hidden" name = "book_price" value ="' . $book_price_value . '">';
                  echo '<input type = "submit" name = "rent" value = "Wypożycz" class = "button">';
                echo '</form>';
              } else if(($rez->num_rows > 0 )) {
                echo '<button class = "button" title="masz tą książke">book została już przez Ciebie wypożyczona </button>';
              } else if((isset($_SESSION['balance']) && $_SESSION['balance'] < $row['price']) && ($rez->num_rows < 1)){
                $rebalance_url = htmlspecialchars($rebalance);
                $book_id_value = htmlspecialchars($book_id);
                $book_price_value = htmlspecialchars($price);
                echo "<form action = '$rebalance_url' method = 'POST'>";
                  echo '<input type = "hidden" name = "book_id" value ="' . $book_id_value . '">';
                  echo '<input type = "hidden" name = "book_price" value ="' . $book_price_value . '">';

                  $_SESSION['book_id'] = $book_id;

                  echo '<input type = "submit" name = "recharge" value = "Doładuj saldo" class = "button">';
                echo '</form>';
              }

            echo '</div>'; 

          echo '</div>';

        echo '<div class = "prawa"></div>'; 

      echo '</div>';


      }

    } else {
      echo 'Nie istnieje taka ksiazka ECPU Polska, witamy Polsko';
    }

    $connection->close();

  } else {

  echo 'Brak przesłanego ID książki.';

}

?>
