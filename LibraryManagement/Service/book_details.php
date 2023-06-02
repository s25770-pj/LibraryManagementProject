<?php

session_start();

if(isset($_GET['id'])){

?>

<link rel="stylesheet" href="../Style/style.css">

<div class = "big_banner">

    <div class = "banner">

        <?php 

            if ((!isset($_SESSION['login']))) {

        //buttoni logowania i rejestracji
        
        echo '<div id = "logowanie">';
            echo '<p>[ <a class = "p" href="../Logowanie_Rejestracja/login_panel.php">Logowanie</a> ]</p>';
        echo '</div>'; 
            
        echo '<div id = "rejestracja">';
            echo '<p>[ <a href="../Logowanie_Rejestracja/rejestracja.php">Rejestracja</a> ]</p>';
        echo '</div>'; 

        } else {

        require_once '../Laczenie_Z_Baza/connect.php';

        $connection = new mysqli($host, $db_user, $db_password, $db_name);

        if ($connection->connect_errno) {
            exit("Błąd połączenia z bazą danych: " .$connection->connect_errno);
        }

        $id = $_SESSION['id'];
        $jakie_balance = "SELECT balance FROM wallets WHERE user_id = '$id'";
        $result = $connection->query($jakie_balance);

        if($result) {

            if($result->num_rows > 0 ) {
            $row = $result->fetch_assoc();                   
            $_SESSION['balance'] = $row['balance'];

            }
        }

        //Przejście do portfela
        $balance = $_SESSION['balance'];
        echo '<div id = "koszykArr">';

            echo '<div id = "koszyk">';
            echo '<img src="cart.png">';
            echo 'Koszyk';
            echo '</div>'; 

        echo '</div>'; 

        echo '<div class = "menu">';

            echo '<form action = "../Panel_Uzytkownika/panel_uzytkownika.php">';
            echo '<input type = "submit" value = "Profil">';
            echo '</form>';

        echo '</div>';

        $balance = number_format($balance, 2, ',', ' ') . " zł";

        echo '<div class = "menu">';

            echo '<form action = "../Panel_Uzytkownika/recharge_balance.php">';
            echo '<input type = "submit" value = "'. $balance .'">';
            echo '</form>';

        echo '</div>';

        }

        ?>

    </div> 

</div>

<div class = "pod_bannerem">


<div class = 'lewa'>

</div> <!-- lewa -->

<div class = 'srodek'>

    <?php

    require_once '../Laczenie_Z_Baza/connect.php';

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno) {
        exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);
    }

    $book_id = $_GET['id'];

    $query = "SELECT * FROM stock WHERE id = $book_id ";

    $result = $connection->query($query);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo '<div class = "zdjecie">';
            $cover = $row ['cover'] . 'r.jpg';
            echo '<img src="../Okladki/' . $cover . '" alt="Book cover">';
            echo '</div>'; 

            echo '<div class = "info">';
                echo '<table>';
                echo '<tr><td> ID: </td><td>' . $row['id'] . '</td></tr><br />';
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
            $data_konca = date('Y-m-d H:i:s');
            $user_id = $_SESSION['id'];

            $czyrentona = "SELECT * FROM rentenia WHERE user_id = ? AND book_id = ? AND return_date > ?";
            $querySelect = $connection->prepare($czyrentona);
            $querySelect->bind_param("iis", $user_id, $book_id, $data_konca);
            $querySelect->execute();
            $rez = $querySelect->get_result();

            if(($_SESSION['balance'] >= $row['price']) && ($rez->num_rows < 1 )){

            //Sprawdzenie czy uzytkownik ma wystarczające balance

            echo '<div class = "rent">';
            echo '<form action = "rentenie_ksiazki.php" method = "POST">';
            echo '<input type = "hidden" name = "book_id" value ="' . $row['id'] . '">';
            echo '<input type = "hidden" name = "book_price" value ="' . $price . '">';
            echo '<input type = "submit" name = "rent" value = "Wypożycz" class = "button">';
            echo '</form>';
            } else if(($rez->num_rows > 0 )) {

                //Sprawdzenie czy uzytkownik już wypożyczył tą książkę

                echo '<div class = "rent">';
                echo '<form action = "../Panel_Uzytkownika/rentenia.php" method = "GET">';
                echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
                echo '<input type = "hidden" name = "book_price" value ="' . $row['price'] . '">';
                echo '<input type = "submit" name = "rentona" value = "book została już przez Ciebie wypożyczona" class = "button">';
                echo '</form>';

            } else {

                echo '<div class = "rent">';
                    echo '<form action = "../Panel_Uzytkownika/rentenia.php" method = "GET">';
                    echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
                    echo '<input type = "hidden" name = "book_price" value ="' . $row['price'] . '">';
                    echo '<input type = "submit" name = "recharge" value = "Doładuj balance" class = "button">';
                    echo '</form>';
                }

                echo '<form action = "index.php">';
                echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';
                echo '</form>';

                echo '</div>'; //rent 

            echo '</div>'; //srodek

        echo '<div class = "prawa">';

        echo '</div>'; //prawa 

    echo '</div>'; //podbannerem

            $rez->close();

        }
    }
    $result->close();
    $connection->close();

} else {

    echo 'Brak przesłanego ID książki.';

}

?>
