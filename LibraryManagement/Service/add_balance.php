<link rel="stylesheet" href="../Style/add_money.css">

<?php

require_once '../Includes/config.php';

session_start();

if (!isset($_SESSION['login'])) {
	header('Location: ' . $page);
	die();
}

if(isset($_POST['recharge_account'])) {

    $recharge_sum = filter_input(INPUT_POST, 'recharge_account', FILTER_VALIDATE_FLOAT);

    if ($recharge_sum !== false) {
        require_once $database;
    
        $id = $_SESSION['id'];

        $query = ("SELECT balance FROM wallets WHERE user_id = '$id'");
        $result = $connection->query($query);

        if ($result) {

        $row = $result->fetch_assoc();
        $add_balance = $row['balance'];
        $new_balance = $add_balance + $recharge_sum;

        $queryUpdate = ("UPDATE wallets SET balance = '$new_balance' WHERE user_id = '$id'");
        $rez = $connection->query($queryUpdate);

        if($rez) {
            if(isset($_POST['book_id'])){
                $book_id = $_POST['book_id'];
                ?>
                <div class = retreat>
                    <form action = "<?php echo $book_details; ?>" method = 'GET'>
                    <input type = "hidden" name = "book_id" value ="<?php echo $book_id; ?>">
                    <?php unset($_SESSION['book_id']); ?>
                    <input type = "submit" name = "retreat" value = "Powrót" class = "button">
                    </form>
                </div>
                <?php
                } else {
                    ?>
                <div class = retreat>
                    <form action = "<?php echo $page; ?>" method = 'GET'>
                    <input type = "submit" name = "retreat" value = "Powrót" class = "button">
                    </form>
                </div>
                <?php
                }
            } else {
                echo "Błąd podczas aktualizacji danych: " . $connection->error;
            } 
        } else {
            echo "Błąd podczas pobierania danych z bazy: " . $connection->error;
        }
        $connection->close();
    } else {
        echo <<<END
        <div class = "wrong_recharge_value"> 
        Błędna wartość doładowania.
        </div>
        END;
    }
}


?>