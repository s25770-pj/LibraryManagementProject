<?php

session_start();

if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../Ksiazki/index.php');
		exit();
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kup Karnet Premium</title>
</head>
<body>

    <?php 

    echo 'Długość trwania: 15 dni <br />';
    echo 'Cena: 20zł <br />';
    echo '<form action = "zakup_premium.php" method = "POST">';
    echo '<input type="submit" name="execute" value="Kup pakiet">';
    echo '</form>';
    echo '[ <a href="userpanel.php">Powrót</a> ]</p>';

    $id = $_SESSION['id'];

    echo 'id: ' . $id . '<br />';
    
    $dataczas = new DateTime(date('Y-m-d H:i:s'));

    echo "Data i czas serwera: " . $dataczas->format('Y-m-d H:i:s') . "<br>";

    require_once '../Laczenie_Z_Baza/connect.php';

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}

    $query = "SELECT dnipremium FROM uzytkownicy WHERE id = '$id' ";
    $rezultat = $polaczenie->query($query);
    $row = $rezultat->fetch_assoc();

    $_SESSION['dnipremium'] = $row['dnipremium'];

    echo 'Data wygasniecia: ' . $_SESSION['dnipremium'] . '<br />';

    $koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);
    $roznica = $dataczas->diff($koniec);

    if($dataczas<$koniec) {

	    echo "Pozostay czas premium: " . $roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s sek');

    } else {

	echo "Premium nieaktywne od: " . $roznica->format('%y lat, %m mies, %d dni, %h godz, %i min, %s sek');

}

    ?>

</body>
</html>