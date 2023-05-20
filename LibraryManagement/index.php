<?php

	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: userpanel.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Księgarnia internetowa</title>

	<link rel="stylesheet" href="style.css">
</head>

<body>
<div class = 'body'>

<div class = 'banner'>

<div class = 'logowanie'>

<p>[ <a class = "p" href="panel_logowania.php">Logowanie</a> ]</p>

	
</div> <!-- logowanie -->

<div class = 'rejestracja'>

<p>[ <a href="rejestracja.php">Rejestracja</a> ]</p>

</div> <!-- rejestracja -->

</div> <!-- banner -->

<div class = "pod_bannerem">

<div class = 'lewa'>
</div> <!-- lewa -->

<div class = 'srodek'>


             </div> <!--srodek-->
             <div class = "prawa">
             </div> <!--prawa-->  

</div> <!-- podbannerem-->
</div> <!-- body -->
	
	<br /><br />
<?php
	if(isset($_SESSION['blad']))	echo $_SESSION['blad'];
?>

</body>
</html>