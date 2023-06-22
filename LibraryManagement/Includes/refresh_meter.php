<?php

session_start();

if (!isset($_SESSION['login']))
{
	header('Location: ' . $page);
	exit();
}
require_once '../Includes/path.php';


    //Pobieranie z bazy danych date konca premium
    $query = "SELECT premiumExpirationDate FROM users WHERE id = ? ";
    $id = $_SESSION['id'];
    $result = $connection->prepare($query);
    $result->bind_param("i", $id);
    $result->execute();
    $result->bind_result($date_time);

    if($result->fetch()) {
        $actual_date_time = new DateTime();
        $database_date_time = new DateTime($date_time);
    }

// Wykonaj porównanie daty i czasu oraz wygeneruj odpowiedź
if ($actual_date_time < $database_date_time) {
    $difference = $actual_date_time->diff($database_date_time);
    $remaining_time = $difference->format('%y years, %m months, %d dni, %h hours, %i minutes, %s seconds');
    echo "Pozostały czas pakietu premium: <br />" . $remaining_time;
} else {
    echo "Pakiet premium nieaktywny.";
}

$connection->close();


?>