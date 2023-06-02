<link rel="stylesheet" href="../Style/add_balance.css">

<?php

session_start();

if (!isset($_SESSION['login']))
{
	header('Location: ' . $local);
	exit();
}

if(isset($_POST['recharge_account'])){

require_once '../path.php';

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno) {

    exit("Błąd połączenia z bazą danych: ". $connection->connect_errno);

}

$id = $_SESSION['id'];

$query = ("SELECT balance FROM wallets WHERE user_id = '$id'");
$result = $connection->query($query);

while($row = $result->fetch_assoc()) {

$balance = $row['balance'];
$recharge_sum = $_POST['recharge_account'];

$new_balance = $balance + $recharge_sum;

$queryUpdate = ("UPDATE wallets SET balance = '$new_balance' WHERE user_id = '$id'");
$rez = $connection->query($queryUpdate);

if($rez) {

    if(isset($_POST['book_id'])){

    $book_id = $_POST['book_id'];

    echo "<br /> Dane zostały zaktualizowane poprawnie.";

    echo '<div class = retreat>';
    echo '<form action = $details method = "GET">';
    echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';

    echo '</form>';
    echo '</div>';

    } else {
        header('Location:' . $rebalance);
    }

} else {
    echo "Błąd podczas aktualizacji danych: " . $connection->error;
}

}

$connection->close();

}


?>