<?php

require_once "../Includes/path.php";

session_start();

if (!isset($_SESSION['login'])) {

		header('Location: ' . $page);
		exit();

	}

if((isset($_GET['book_id'])) && (isset($_POST['book_price']))) {

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno) {

        exit("Błąd połączenia z bazą danych: " . $connection->connect_errno);

    }
    $book_price = $_POST['book_price'];
    $book_id = $_GET['book_id'];

    $HTML_injection_query = ("SELECT price FROM stock WHERE id = ?");
    $HTML_injection = $connection->prepare($HTML_injection_query);

    if ($HTML_injection) {
        $HTML_injection->bind_param("i", $book_id);
        $HTML_injection->execute();
    }
    $is_injected = $HTML_injection->get_result();

    if($is_injected->num_rows > 0) {
        $row_book = $is_injected->fetch_assoc();
        $real_price = $row_book['price'];
    }

    if($book_price === $real_price) {

    $id = $_SESSION['id'];

    $what_balance_query = ("SELECT * FROM wallets WHERE user_id = ?");
    $what_balance = $connection->prepare($what_balance_query);

    if($what_balance) {
        $what_balance->bind_param("i", $id);
        $what_balance->execute();
    }

    $result = $what_balance->get_result();

    if ($result->num_rows > 0 ) {
        $row = $result->fetch_assoc();

        $price = $_POST['book_price'];
        $balance = $row['balance'];
        $new_balance = $balance - $price;

        //Zmiana salda na te po purchaseie
        
        $set_new_balance = ("UPDATE wallets SET balance = ? WHERE user_id = ?");
        $rez = $connection->prepare($set_new_balance);
        
        if($rez) {

            $rez->bind_param("di", $new_balance, $id);
            $rez->execute();

            if($rez->affected_rows > 0) {

                echo 'Dane zostaly wstawione poprawnie';

            } else {

                echo 'Dane nie zostaly wstawione poprawnie';

            }

            echo '<div class = "rent">';
            echo '<form action = '. $page .' method = "POST">';
            echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
            echo '<input type = "hidden" name = "book_price" value ="' . $price . '">';
            echo '<input type = "submit" name = "rent" value = "Powrót">';
            echo '</form>';

            $rez->close();

        } else {

        echo "Błąd przygotowania zapytania: " . $connection->error;

        }

        //Wstawianie nowego wypożyczenia do bazy

        $new_rental = ("INSERT INTO rentals (user_id, book_id, rent_date, return_date) VALUES (?, ?, ?, ?)");
        $result = $connection->prepare($new_rental);

        $date_time = date('Y-m-d H:i:s');
        $new_date_time = date('Y-m-d H:i:s', strtotime('+7 days'));

        if ($result) {

            $result->bind_param("iiss", $id, $book_id, $date_time, $new_date_time);
            $result->execute();

            if ($result->affected_rows > 0) {

                echo 'Dane zostały wstawione poprawnie.';

            } else {

                echo 'Błąd podczas wstawiania danych.';

            }

        }
        //Wstawienie nowej transakcji do bazy

        $new_transaction = ("INSERT INTO transactions (wallet_id, transaction_type, balance, date_time) VALUES (?, ?, ?, ?)");
        $res = $connection->prepare($new_transaction);

        if ($res) {

            $wallet_id = $row['id'];
            $purchase = "purchase";
            $date_time = date('Y-m-d H:i:s');

            $res->bind_param("isds", $wallet_id, $purchase, $book_price, $date_time);
            $res->execute();

            if($res->affected_rows > 0) {

                echo 'Dane zostały wstawione poprawnie.';

            } else {

                echo 'Błąd podczas wstawiania danych.';

            }
            
        }

    }   
} else {
    $_SESSION['HTML_injection'] = true;
}

    $connection->close();

    header('Location: ' . $page);

}


?>