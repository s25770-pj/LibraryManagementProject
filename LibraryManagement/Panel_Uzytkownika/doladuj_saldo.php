<html>

<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: index.php');
		exit();
	}

?>
<head>

<link rel="stylesheet" href="../Style/style.css">
<link rel="stylesheet" href="../Style/doladuj_saldo.css">

</head>

<body>

<div class = 'body'>

<div class = 'banner'>

</div> <!-- banner -->

<div class = "pod_bannerem">

<div class = 'lewa'>

</div> <!-- lewa -->

<div class = 'srodek'>

<?php


if (!isset($_GET['id_ksiazki'])){

    ?>

<div class = "kwota">
    20 zł
    <form action = "dodanie_pieniedzy.php" method = "POST">
    <input type="hidden" name="kwota_doladowania" value="20.00">
    <input type="submit" name="doladuj" value="Doładuj konto" class = "przycisk">
    </form>
</div>

<div class = "kwota">
    50 zł
    <form action = "dodanie_pieniedzy.php" method = "POST">
    <input type="hidden" name="kwota_doladowania" value="50.00">
    <input type="submit" name="doladuj" value="Doładuj konto" class = "przycisk">
    </form>
</div>

<div class = "kwota">
    100 zł
    <form action = "dodanie_pieniedzy.php" method = "POST">
    <input type="hidden" name="kwota_doladowania" value="100.00">
    <input type="submit" name="doladuj" value="Doładuj konto" class = "przycisk">
    </form>

</div>

<?php

echo '<form action = "../Ksiazki/index.php">';
echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';
echo '</form>';

} else {

    ?>

    <div class = "kwota">
    20 zł
    <form action = "dodanie_pieniedzy.php" method = "POST">
    <?php
    echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
    ?>
    <input type="hidden" name="kwota_doladowania" value="20.00">
    <input type="submit" name="doladuj" value="Doładuj konto" class = "przycisk">
    </form>
</div>

<div class = "kwota">
    50 zł
    <form action = "dodanie_pieniedzy.php" method = "POST">
    <?php
    echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
    ?>
    <input type="hidden" name="kwota_doladowania" value="50.00">
    <input type="submit" name="doladuj" value="Doładuj konto" class = "przycisk">
    </form>
</div>

<div class = "kwota">
    100 zł
    <form action = "dodanie_pieniedzy.php" method = "POST">
    <?php
    echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
    ?>
    <input type="hidden" name="kwota_doladowania" value="100.00">
    <input type="submit" name="doladuj" value="Doładuj konto" class = "przycisk">
    </form>

</div>

<?php

echo '<form action = "../Ksiazki/szczegoly_ksiazki.php" method = "GET">';
echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">';
echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';
echo '</form>';

}

?>

</div> <!--srodek-->

             <div class = "prawa">

             </div> <!--prawa-->  

</div> <!-- podbannerem-->

</div> <!-- body -->

</body>

</html>