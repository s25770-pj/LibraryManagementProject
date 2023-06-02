<html>

<?php

require_once '../path.php';

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location: ' . $local);
		exit();
	}

?>
<head>

<link rel="stylesheet" href="../Style/recharge_balance.css">

</head>

<body>

<div id = "background"></div>

<div id = "packages">

    <?php


    if (!isset($_GET['book_id'])){

        if (isset($_POST['recharge_account'])) {
            $recharge_sum = $_POST['recharge_account'];
        }

    ?>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge_account" value="20.00">
        <input type="submit" name="recharge" value="20 zł" class = "button_sum <?php if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '20.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge_account" value="50.00">
        <input type="submit" name="recharge" value="50 zł" class = "button_sum <?php if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '50.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge_account" value="100.00">
        <input type="submit" name="recharge" value="100 zł" class = "button_sum <?php if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '100.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
    <?php
        echo '<form action ='. $balance .' method = "POST">';
        if (isset($_POST['recharge_account'])) {
        echo '<input type="hidden" name="recharge_account" value='.
        $recharge_sum .'>';
        }
        ?>
        <input type="submit" name="recharge" value="Doładuj" class = "button">
        </form>
    </div>

    <?php

    echo '<form action = '. $local .'>';
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';
    echo '</form>';

    } else {

        ?>

    <div class = "sum">
        <form action = "recharge_balance.php" method = "POST">
        <?php
        echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">'
        ?>
        <input type="hidden" name="recharge_account" value="20.00">
        <input type="submit" name="recharge" value="20 zł" class = "button_sum <?php if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '20.00') echo 'podswietlony'; ?>">>
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <?php
        echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">'
        ?>
        <input type="hidden" name="recharge_account" value="50.00">
        <input type="submit" name="recharge" value="50 zł" class = "button_sum <?php if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '50.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <?php
        echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">'
        ?>
        <input type="hidden" name="recharge_account" value="100.00">
        <input type="submit" name="recharge" value="100 zł" class = "button_sum <?php if(isset($_POST['recharge_account']) && $_POST['recharge_account'] == '100.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
        <form method = "POST">
        <?php
        echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">'
        ?>
        <input type="hidden" name="recharge_account" value="100.00">
        <input type="submit" name="recharge" value="100 zł" class = "button">
        </form>
    </div>


    <?php

    echo '<form action ='. $details .' method = "GET">';
    echo '<input type = "hidden" name = "book_id" value ="' . $book_id . '">';
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';
    echo '</form>';

    }

    ?>

</div>

</body>

</html>