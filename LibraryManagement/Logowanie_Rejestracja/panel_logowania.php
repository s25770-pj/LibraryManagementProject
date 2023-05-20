<?php 

session_start();

if (isset($_SESSION['zalogowany']))
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
    <title>Logowanie</title>
</head>
<body>
<form action="zaloguj.php" method="post">
	
    Login: <br /> <input type="text" name="login" /> <br />
    Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
    <input type="submit" value="Zaloguj się" />

    <p>[ <a href="../Ksiazki/index.php">Powrót</a> ]</p>

</form>
    
</body>
</html>