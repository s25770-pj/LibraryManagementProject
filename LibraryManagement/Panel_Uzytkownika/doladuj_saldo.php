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

<link rel="stylesheet" href="../Style/doladuj_saldo.css">

</head>

<body>

<div id = "tlo"></div>

<div id = "pakiety">

    <?php


    if (!isset($_GET['id_ksiazki'])){

        if (isset($_POST['kwota_doladowania'])) {
            $KwotaDoladowania = $_POST['kwota_doladowania'];
        }

    ?>

    <div class = "kwota">
        <form method = "POST">
        <input type="hidden" name="kwota_doladowania" value="20.00">
        <input type="submit" name="doladuj" value="20 zł" class = "przycisk_kwota <?php if(isset($_POST['kwota_doladowania']) && $_POST['kwota_doladowania'] == '20.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "kwota">
        <form method = "POST">
        <input type="hidden" name="kwota_doladowania" value="50.00">
        <input type="submit" name="doladuj" value="50 zł" class = "przycisk_kwota <?php if(isset($_POST['kwota_doladowania']) && $_POST['kwota_doladowania'] == '50.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "kwota">
        <form method = "POST">
        <input type="hidden" name="kwota_doladowania" value="100.00">
        <input type="submit" name="doladuj" value="100 zł" class = "przycisk_kwota <?php if(isset($_POST['kwota_doladowania']) && $_POST['kwota_doladowania'] == '100.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
        <form action = "dodanie_pieniedzy.php" method = "POST">
        <?php
        if (isset($_POST['kwota_doladowania'])) {
        echo '<input type="hidden" name="kwota_doladowania" value='.
        $KwotaDoladowania .'>';
        }
        ?>
        <input type="submit" name="doladuj" value="Doładuj" class = "przycisk">
        </form>
    </div>

    <?php

    echo '<form action = "../Ksiazki/index.php">';
    echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';
    echo '</form>';

    } else {

        ?>

    <div class = "kwota">
        <form action = "doladuj_saldo.php" method = "POST">
        <?php
        echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
        ?>
        <input type="hidden" name="kwota_doladowania" value="20.00">
        <input type="submit" name="doladuj" value="20 zł" class = "przycisk_kwota <?php if(isset($_POST['kwota_doladowania']) && $_POST['kwota_doladowania'] == '20.00') echo 'podswietlony'; ?>">>
        </form>
    </div>

    <div class = "kwota">
        <form method = "POST">
        <?php
        echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
        ?>
        <input type="hidden" name="kwota_doladowania" value="50.00">
        <input type="submit" name="doladuj" value="50 zł" class = "przycisk_kwota <?php if(isset($_POST['kwota_doladowania']) && $_POST['kwota_doladowania'] == '50.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "kwota">
        <form method = "POST">
        <?php
        echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
        ?>
        <input type="hidden" name="kwota_doladowania" value="100.00">
        <input type="submit" name="doladuj" value="100 zł" class = "przycisk_kwota <?php if(isset($_POST['kwota_doladowania']) && $_POST['kwota_doladowania'] == '100.00') echo 'podswietlony'; ?>">
        </form>
    </div>

    <div class = "doladowanie">
        <form method = "POST">
        <?php
        echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">'
        ?>
        <input type="hidden" name="kwota_doladowania" value="100.00">
        <input type="submit" name="doladuj" value="100 zł" class = "przycisk">
        </form>
    </div>


    <?php

    echo '<form action = "../Ksiazki/szczegoly_ksiazki.php" method = "GET">';
    echo '<input type = "hidden" name = "id_ksiazki" value ="' . $ksiazkaid . '">';
    echo '<input type = "submit" name = "powrot" value = "Powrót" class = "przycisk">';
    echo '</form>';

    }

    ?>

</div>

</body>

</html>