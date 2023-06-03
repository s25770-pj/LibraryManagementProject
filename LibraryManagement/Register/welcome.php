<?php

require_once '../Includes/path.php';

	session_start();
	
	if (!isset($_SESSION['successfull_registration']))
	{
		header('Location: '.$index);
		exit();
	}
	else
	{
		unset($_SESSION['successfull_registration']);
	}
	
	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_password1'])) unset($_SESSION['fr_password1']);
	if (isset($_SESSION['fr_password2'])) unset($_SESSION['fr_password2']);
	if (isset($_SESSION['fr_rules'])) unset($_SESSION['fr_rules']);
	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_password'])) unset($_SESSION['e_password']);
	if (isset($_SESSION['e_rules'])) unset($_SESSION['e_rules']);
	if (isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Księgarnia internetowa</title>
</head>

<body>
	
	Dziękujemy za rejestrację w serwisie! Możesz już zalogować się na swoje konto!<br /><br />
	<?php

	echo' <a href='. $index .'>Zaloguj się na swoje konto!</a>';
	?>
	<br /><br />

</body>
</html>