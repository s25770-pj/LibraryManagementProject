<html>

<?php

require_once '../Includes/path.php';

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location: ' . $index);
		exit();
	}

?>
<head>

<link rel="stylesheet" href="../Style/idn.css">

<style>body{background-color: black;}</style>
</head>

<body>

<div id = "background"></div>

<div id = "packages">

    <?php

        if (isset($_POST['recharge_account'])) {
            $recharge_sum = $_POST['recharge_account'];
        }

    ?>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge_account" value="20.00">
        <input type="hidden" name="book_id" value="<?php $book_id ?>">
        <input type="submit" name="recharge" value="20 zł" class = "button_sum 
        <?php 
        if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '20.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge_account" value="50.00">
        <input type="hidden" name="book_id" value="<?php $book_id ?>">
        <input type="submit" name="recharge" value="50 zł" class = "button_sum 
        <?php
        if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '50.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge_account" value="100.00">
        <input type="hidden" name="book_id" value="<?php $book_id ?>">
        <input type="submit" name="recharge" value="100 zł" class = "button_sum 
        <?php
        if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '100.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
    <?php
    if (isset($_SESSION['book_id'])){

        $book_id = $_SESSION['book_id'];
        
        echo '<form action ='. $add_balance .' method = "POST">';
        if (isset($_POST['recharge_account'])) {
        echo '<input type="hidden" name="recharge_account" value='.
        $recharge_sum .'>';
        echo '<input type="hidden" name="book_id" value='.$book_id.'>';
        }
        ?>

        <input type="submit" name="recharge" value="Doładuj" class = "button">
        </form>
        <?php
    } else {

        echo '<form action ='. $add_balance .' method = "POST">';
        if (isset($_POST['recharge_account'])) {
        echo '<input type="hidden" name="recharge_account" value='.
        $recharge_sum .'>';
        }
        ?>
        <input type="submit" name="recharge" value="Doładuj" class = "button">
        </form>
        <?php
    }
    ?>
    </div>

    <?php

    echo '<form action = '. $index .'>';
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';
    echo '</form>';

?>

</div>

</body>

</html>