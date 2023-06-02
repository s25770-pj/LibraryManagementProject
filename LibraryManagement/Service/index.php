<?php

require_once '../path.php';

	session_start();

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8" />
	<title>Księgarnia internetowa</title>
    <script src="../JS/wyszukiwarka.js"></script>
	<link rel="stylesheet" href="../Style/style.css">

</head>

<body>

<div class = "big_banner">

    <div class = 'banner'>

        <?php 

        if ((!isset($_SESSION['login']))) {

            //buttoni logowania i rejestracji
            
            echo '<div id = "logowanie">';

                echo '<p>[ <a class = "p" href="'. $panel .'">Logowanie</a> ]</p>';

            echo '</div>'; 
                
            echo '<div id = "rejestracja">';

                echo '<p>[ <a href="'. $register .'">Rejestracja</a> ]</p>';

            echo '</div>'; 

        } else {

            $connection = new mysqli($host, $db_user, $db_password, $db_name);

            if ($connection->connect_errno) {

                exit("Błąd połączenia z bazą danych: " .$connection->connect_errno);

            }

        $id = $_SESSION['id'];
        $what_balance = "SELECT balance FROM wallets WHERE user_id = '$id'";
        $result = $connection->query($what_balance);

        if($result) {

            if($result->num_rows > 0 ) {

                $row = $result->fetch_assoc();                   
                $_SESSION['balance'] = $row['balance'];

            }

        }

        //Przejście do portfela
        $balance = $_SESSION['balance'];

        echo '<div id = "cart_array">';

            echo '<div id = "cart">';

                echo '<img src="cart.png">';
                echo 'Koszyk';

            echo '</div>'; 

        echo '</div>'; 

        echo '<div class = "menu">';

            echo '<form action = "'.$upanel.'">';
            echo '<input type = "submit" value = "Profil">';
            echo '</form>';

        echo '</div>';

            $balance = number_format($balance, 2, ',', ' ') . " zł";

            echo '<div class = "menu">';

                echo '<form action = "'. $rebalance .'">';
                echo '<input type = "submit" value = "'. $balance .'">';
                echo '</form>';

            echo '</div>';

        }

        ?>

    </div>

    <div id = "searching">

        <label for="what_category"></label>

        <select id="what_category" oninput="searchBooks()" class = "search_category">
            <option value="" selected>Wszystkie gatunki</option>
            <option value="Thriller">Thriller</option>
            <option value="Fantastyka">Fantastyka</option>
            <option value="Akcja">Akcja</option>
            <option value="Romans">Romans</option>
        </select>

        <input type="text" id="find_phrase" placeholder="Wysearch książkę lub authora" oninput="searchBooks()" class="find_text">

    </div>

</div>

<div class = 'pod_bannerem'>

    <div class = 'lewa'></div>

    <div class = 'srodek'>

        <div class = 'searching'></div>

        <div id='bookResults'></div>

        <?php

        if ((isset($_SESSION['login']))) {

        $connection->close();

        }

        ?> 
                
        <br /><br />

        <?php

        if(isset($_SESSION['error']))	echo $_SESSION['error'];

        ?>

    </div>

    <div class = "prawa"></div> 

</div>

</body>

</html>