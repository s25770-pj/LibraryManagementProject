<?php

require_once "../Includes/path.php";

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
<!-- <body> -->
  <!-- <h1>Tytuł artykułu</h1>
  <div class="excerpt">
    <p>To jest fragment artykułu.</p>
    <p id="read-more" class="content">To jest pełna treść artykułu.</p>
  </div>
  <a href="#read-more">Czytaj dalej</a>
</body> -->
</html>



<div class = "pod_bannerem">


<div class = 'lewa'>

</div> <!-- lewa -->

<div class = 'srodek'>

    <?php

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno) {
        exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);
    }

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
            echo '</div>'; //info

            echo '<div id = "description">';
                echo '<table>';
                echo '<tr><td></td><td>' . $row['description'] . '</td></tr><br />';
                echo '</table>';
            echo '</div>'; //description

            $price = $row['price'];
            $book_id = $row['id'];
            $end_date = date('Y-m-d H:i:s');
            $user_id = $_SESSION['id'];

            $is_rent = "SELECT * FROM rentals WHERE user_id = ? AND book_id = ? AND return_date > ?";
            $querySelect = $connection->prepare($is_rent);
            $querySelect->bind_param("iis", $user_id, $book_id, $end_date);
            $querySelect->execute();
            $rez = $querySelect->get_result();

            if(($_SESSION['balance'] >= $row['price']) && ($rez->num_rows < 1 )){

            //Sprawdzenie czy uzytkownik ma wystarczające balance

            echo '<div class = "rent">';
            echo "<form action = '$rent_book?book_id=".$book_id."' method = 'POST'>";
            echo '<input type = "hidden" name = "book_price" value ="' . $price . '">';
            echo '<input type = "submit" name = "rent" value = "Wypożycz" class = "button">';
            echo '</form>';
            } else if(($rez->num_rows > 0 )) {

                //Sprawdzenie czy uzytkownik już wypożyczył tą książkę

                echo '<div class = "rent">';
                echo '<button class = "button" title="masz tą książke">book została już przez Ciebie wypożyczona </button>';

            } else if(($_SESSION['balance'] < $row['price']) && ($rez->num_rows < 1)){

                echo '<div class = "rent">';
                    echo "<form action = '$rebalance' method = 'POST'>";
                    echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
                    echo '<input type = "hidden" name = "book_price" value ="' . $price . '">';
                    $_SESSION['book_id'] = $book_id;
                    echo '<input type = "submit" name = "recharge" value = "Doładuj saldo" class = "button">';
                    echo '</form>';
                }

                echo '</div>'; //rent 

            echo '</div>'; //srodek

        echo '<div class = "prawa">';

        echo '</div>'; //prawa 

    echo '</div>'; //podbannerem


        }
    } else {
      echo 'Nie istnieje taka ksiazka ECPU Polska, witamy Polsko';
    }

    $connection->close();

} else {

    echo 'Brak przesłanego ID książki.';

}

?>
