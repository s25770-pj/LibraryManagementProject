<html>
<?php
require_once '../Includes/config.php';

session_start();

if (!isset($_SESSION['login']))
	{
		header('Location: ' . $page);
		exit();
	}
    $buypremium_sum = '';

if (isset($_POST['buypremium'])) {
    $buypremium_value = $_POST['buypremium'];

    if ($buypremium_value === '20') {
        $buypremium_sum = '20.00';
    } elseif ($buypremium_value === '50') {
        $buypremium_sum = '50.00';
    } elseif ($buypremium_value === '100') {
        $buypremium_sum = '100.00';
    }
}
?>
<head>
<link rel="stylesheet" href="../Style/main.css">

<style>body{background-color: black;}</style>
</head>

<body>

<div id = "background"></div>

<div id = "packages">

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="buypremium" value="20.00">
        <input type="submit" name="buypremium_submit" value="20 zł" class = "button_sum 
        <?php 
        if($buypremium_sum === '20.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="buypremium" value="50.00">
        <input type="submit" name="buypremium_submit" value="50 zł" class = "button_sum 
        <?php
        if($buypremium_sum === '50.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "sum">
        <form method = "POST">
        <input type="hidden" name="buypremium" value="100.00">
        <input type="submit" name="buypremium_submit" value="100 zł" class = "button_sum 
        <?php 
        if($buypremium_sum === '100.00') echo 'active'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
    <?php
    ?>
        <form action ="<?php echo $add_balance; ?>" method = "POST">
        <input type="hidden" name="buypremium_account" value="<?php echo $buypremium_sum; ?>">
        <input type="submit" name="buypremium_submit" value="Doładuj" class = "button">
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