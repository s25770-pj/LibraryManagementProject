<?php 

require_once '../Includes/path.php';

session_start();

if (isset($_SESSION['login']))
	{
		header('Location: '.$index);
		exit();
	}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>

    <form action= "<?php echo $login ?>" method="POST">
	
    Login: <br /> <input type="text" name="login" /> <br />
    Hasło: <br /> <input type="password" name="password" /> <br /><br />

    <input type="submit" value="Zaloguj się" />

    <?php

    echo '<p>[ <a href='. $index .'>Powrót</a> ]</p>';

    ?>

</form>
    
</body>
</html>