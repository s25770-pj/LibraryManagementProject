<link rel="stylesheet" href="../Style/header.css">

<div class = "big_banner">

    <?php

    require_once '../Includes/config.php';

    $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
    $filename = basename($parsedUrl['path']);
    if($filename != 'index.php' && $filename != 'Service')
    {
        ?>
        <div id = "go_back">
            <button class = "button_back" onclick="window.location.href = '<?php echo $page; ?>'">Powrót do menu</button>
        </div>
    <?php
    }
    ?>

    <div class = 'banner'>

        <?php 

        if ((!isset($_SESSION['login']))) {
            echo '<div class = "menu">';
            echo '<button class="button_back" onclick="window.location.href = \'' . $login_panel . '\'">Logowanie</button>';
            echo '</div>';

            echo '<div class = "menu" >';
            echo '<button class="button_back" onclick="window.location.href = \'' . $registration . '\'">Rejestracja</button>';
            echo '</div>';
        } else {

            $id = $_SESSION['id'];
            $what_balance = "SELECT balance FROM wallets WHERE user_id = '$id'";
            $result = $connection->query($what_balance);

            if($result) {

                if($result->num_rows > 0 ) {

                $row = $result->fetch_assoc();                   
                $_SESSION['balance'] = $row['balance'];

                }

            }

            $add_balance = $_SESSION['balance'];
            if($_SESSION['access'] === 'admin') {
            echo '<div class = "menu" >';

                echo '<form action = "'. $add_book .'">';
                echo '<input type = "submit" value = "Dodaj książkę">';
                echo '</form>';

            echo '</div>';
            }

            echo '<div class = "menu" >';

                echo '<form action = "'. $package_premium .'">';
                echo '<input type = "submit" value = "(gwiazda)Premium">';
                echo '</form>';

            echo '</div>';

            echo '<div class = "menu" >';

                echo '<form action = "'. $rentals .'">';
                echo '<input type = "submit" value = "Wypożyczenia">';
                echo '</form>';

            echo '</div>';

            echo '<div id = "cart_array">';

                echo '<div id = "cart">';

                    echo "<img src='$images/cart.png'>";
                    echo 'Koszyk';

                echo '</div>'; 

            echo '</div>'; 

            $add_balance = number_format($add_balance, 2, ',', ' ') . " zł";

            echo '<div class = "menu">';

                echo '<form action = "'. $rebalance .'">';
                echo '<input type = "submit" value = "'. $add_balance .'">';
                echo '</form>';

            echo '</div>';

        }

    echo "</div>";



            
    ?>
        
    <div id = "logout">
        <?php
        if(isset($_SESSION['login'])){
        ?>
        <button class = "button_back" onclick="window.location.href = '<?php echo $logout; ?>'">Wyloguj się</button>
        <?php
        }
        ?>
    </div>
    <?php
    if($filename == 'index.php' || $filename == 'Page' ){
        ?>
        <div id="searching">
            <label for="what_category">
            <select id="what_category" onchange="searchBooks()" class="search_category"><option value="">Wybierz kategorie</option>
            <?php 
            
            $query = "SELECT name FROM category";
            $result=$connection->query($query);        
            while($row = $result->fetch_assoc())
            {
                echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
            }
            ?>
            </select>
            </label>

        <input type="text" id="find_phrase" placeholder="Wyszukaj książkę lub autora" oninput="searchBooks()" class="find_text">
        </div>

        <?php
    }

    ?>

</div>
