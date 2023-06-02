<?php

require_once "../path.php";

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location:'. $local);
		exit();
	}

if (isset($_POST["execute"]) && (isset($_POST['packet_price']))){

    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    
    if(!$connection) {

        exit("Błąd połączenia z baza danych: " . mysqli_connect_error());

    }


    $id = $_SESSION['id'];

    //Sprawdzenie czy można dodać dni premium

    $query = "SELECT premiumExpirationDate FROM users WHERE id = ?";
    $resultPremium = $connection->prepare($query);
    $resultPremium->bind_param("i", $id);
    $resultPremium->execute();
    $resultPremium->store_result();
    $resultPremium->bind_result($premiumExpirationDate);

    if($resultPremium->fetch()){

    $actual_date_time = new DateTime($premiumExpirationDate);
    $actual_date_time->modify('+ 15 days');
    $new_date_time = $actual_date_time->format('Y-m-d H:i:s');

    $today = new DateTime();

    $what_balance = "SELECT balance FROM wallets WHERE user_id = ? ";
    $resultbalance = $connection->prepare($what_balance);
    $resultbalance->bind_param("i", $id);
    $resultbalance->execute();
    $resultbalance->store_result();
    $resultbalance->bind_result($balance);

    if ($resultbalance->fetch()) {

    echo 'balance: ' . $balance;

    if ($actual_date_time > $today) {

        $new_date_time = $actual_date_time->format('Y-m-d H:i:s');

        $update_query = ("UPDATE users SET premiumExpirationDate = ? WHERE id = ?");
        $update_result = $connection->prepare($update_query);
        $update_result->bind_param("si", $new_date_time, $id);

        if($update_result->execute()) {

            header('Location:'. $ppremium);

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $update_result->error;

        }

        $update_result->close();

        $wallet_id = $_SESSION['wallet_id'];
        $package_price = $_POST['package_price'];
        $new_balance = $balance - $package_price;

        echo 'price pakietu: ' . $package_price;
        echo 'Nowe balance: ' . $new_balance;

        $minus_balance = ("UPDATE wallets SET balance = ? WHERE id = ?");
        $result_new_balance = $connection->prepare($minus_balance);
        $result_new_balance->bind_param("di", $new_balance, $wallet_id);

        if($result_new_balance->execute()) {

            $result_new_balance->execute();

            header('Location:'. $ppremium);

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $update_result->error;

        }

    } else {

        $new_date_time = $today->format('Y-m-d H:i:s');

        $update_query = "UPDATE users SET premiumExpirationDate = ? WHERE id = ?";
        $update_result = $connection->prepare($update_query);
        $update_result->bind_param("si", $new_date_time, $id);

        if($update_result->execute()) {

            header('Location:'. $ppremium);

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $update_result->error;

        }

        $wallet_id = $_SESSION['wallet_id'];
        $package_price = $_POST['package_price'];
        $balance = $_SESSION['balance'];
        $new_balance = $balance - $package_price;

        $minus_balance = ("UPDATE wallets SET balance = ? WHERE id = ?");
        $result_new_balance = $connection->prepare($minus_balance);
        $result_new_balance->bind_param("di", $new_balance, $wallet_id);

        if($result_new_balance->execute()) {

            header('Location:'. $ppremium);

        } else {

            echo "Błąd podczas aktualizacji ilości dni premium: " . $update_result->error;

        }

    }

    }

    $connection->close();

    unset($_POST["execute"]);
} else {
    echo 'Błąd podcas pobierania salda użytkownika.';
}
} else {
    header('Location:'. $ppremium);
}
?>