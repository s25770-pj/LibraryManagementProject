<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kup Karnet Premium</title>
</head>
<body>
    <?php 

    require_once "connect.php";

    $connect = new mysqli($host, $db_user, $db_password, $db_name);
    
    if(!$connect) {
        exit("Błąd połączenia z baza danych: " . mysqli_connect_error());
    }

    echo 'Długość trwania: 15 dni <br />';
    echo 'Cena: 20zł <br />';
    echo '<form method = "POST">';
    echo '<input type="button" name="execute" value="Kup pakiet">';
    echo '</form>';

    if (isset($_POST["execute"])){
        $dnipremium = $_SESSION["dnipremium"];
        $dnipremium = $dnipremium + 15;
    }

    ?>
</body>
</html>