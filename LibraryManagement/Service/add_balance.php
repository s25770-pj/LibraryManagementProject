<link rel="stylesheet" href="../Style/add_money.css">

<?php

session_start();

if (!isset($_SESSION['login']))
{
	header('Location: ' . $index);
	exit();
}

if(isset($_POST['recharge_account'])){

require_once '../Includes/path.php';

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno) {

    exit("Błąd połączenia z bazą danych: ". $connection->connect_errno);

}

$id = $_SESSION['id'];

$query = ("SELECT balance FROM wallets WHERE user_id = '$id'");
$result = $connection->query($query);

while($row = $result->fetch_assoc()) {

$add_balance = $row['balance'];
$recharge_sum = $_POST['recharge_account'];

$new_balance = $add_balance + $recharge_sum;

$queryUpdate = ("UPDATE wallets SET balance = '$new_balance' WHERE user_id = '$id'");
$rez = $connection->query($queryUpdate);

if($rez) {

    if(isset($_POST['book_id'])){

    $book_id = $_POST['book_id'];

    echo '<div class = retreat>';
    echo "<form action = '$book_details' method = 'GET'>";
    echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
    unset($_SESSION['book_id']);
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';

    echo '</form>';
    echo '</div>';

    } else {
        echo '<div class = retreat>';
    echo "<form action = '$index' method = 'GET'>";
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';

    echo '</form>';
    echo '</div>';
    }

} else {
    echo "Błąd podczas aktualizacji danych: " . $connection->error;
}

} 

$connection->close();

}


?>