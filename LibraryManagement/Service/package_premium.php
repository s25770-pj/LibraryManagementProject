<?php

session_start();

require_once "../Includes/path.php";

if (!isset($_SESSION['login']))
	{
		header('Location:'. $local);
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kup Karnet Premium</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/script.js"></script>
</head>
<body>

    <?php 

    //Kupno premium 15 dni

    echo 'Długość trwania: 15 dni <br />';
    echo 'price: 20zł <br />';
    echo '<form action = '. $premium .'method = "POST">';
    echo '<input type="hidden" name="packet_price" value="20">';
    echo '<input type="submit" name="execute" value="Kup pakiet">';
    echo '</form>';
    echo '[ <a href= '. $user_panel .'>Powrót</a> ]</p>';

    $id = $_SESSION['id'];

    //Data i czas serwera

    $date_time = new DateTime(date('Y-m-d H:i:s'));

    echo "Data i czas serwera: " . $date_time->format('Y-m-d H:i:s') . "<br>";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}

    //Pobranie daty konca premium dla zalogowanego uzytkownika
    
    $query = "SELECT premiumExpirationDate FROM users WHERE id = '$id' ";
    $result = $connection->query($query);
    $row = $result->fetch_assoc();

    $_SESSION['premiumExpirationDate'] = $row['premiumExpirationDate'];

    echo 'Data wygasniecia: ' . $_SESSION['premiumExpirationDate'] . '<br />';

    //Czas do końca premium

    $end = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['premiumExpirationDate']);
    $difference = $date_time->diff($end);

    echo '<div id = "counter">';

    if($date_time<$end) {

	    echo "Pozostały czas pakietu premium: <br />" . $difference->format('%y years, %m months, %d dni, %h hours, %i min, %s sek');

    } else {

	echo "Pakiet premium nieaktywne.";

}

    ?>

</body>
</html>