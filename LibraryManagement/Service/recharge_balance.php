<html>

<?php

require_once '../Includes/path.php';

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location: ' . $page);
		exit();
	}

    $recharge_sum = '';

if (isset($_POST['recharge'])) {
    $recharge_value = $_POST['recharge'];

    if ($recharge_value === '20') {
        $recharge_sum = '20.00';
    } elseif ($recharge_value === '50') {
        $recharge_sum = '50.00';
    } elseif ($recharge_value === '100') {
        $recharge_sum = '100.00';
    }
}

?>
<head>

<link rel="stylesheet" href="../Style/idn.css">

<style>body{background-color: black;}</style>
</head>

<body>

<div id = "background"></div>

<div id = "packages">

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge" value="20.00">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <input type="submit" name="recharge_submit" value="20 zł" class = "button_sum 
        <?php 
        if($recharge_sum === '20.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge" value="50.00">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <input type="submit" name="recharge_submit" value="50 zł" class = "button_sum 
        <?php
        if($recharge_sum === '50.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="recharge" value="100.00">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <input type="submit" name="recharge_submit" value="100 zł" class = "button_sum 
        <?php
        if($recharge_sum === '100.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
    <?php
        if (isset($_SESSION['book_id'])) {
            $book_id = $_SESSION['book_id'];
        }
    ?>
        <form action ="<?php echo $add_balance; ?>" method = "POST">
        <input type="hidden" name="recharge_account" value="<?php echo $recharge_sum; ?>">
        <?php if (isset($_SESSION['book_id'])) { ?>
        <input type="hidden" name="book_id" value= "<?php echo $book_id; ?>">
        <?php } ?>
        <input type="submit" name="recharge_submit" value="Doładuj" class = "button">
        </form>
    </div>

    <?php

    echo '<form action = '. $page .'>';
    echo '<input type = "submit" name = "retreat" value = "Powrót" class = "button">';
    echo '</form>';

?>

</div>

</body>

</html>