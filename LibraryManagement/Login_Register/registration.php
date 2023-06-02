<?php

require_once '../path.php';

	session_start();
	
	if (isset($_POST['email']))
	{
		$OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		//checkenie długości nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$OK=false;
			$_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($password1!=$password2)
		{
			$OK=false;
			$_SESSION['e_password']="Podane hasła nie są identyczne!";
		}	

		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		//Czy zaakceptowano rules?
		if (!isset($_POST['rules']))
		{
			$OK=false;
			$_SESSION['e_rules']="Potwierdź akceptację rulesu!";
		}				
		
		//Bot or not?
		$secret = "6Le75SQmAAAAAIcJxQeeNxHMuCRhaf-Pqq4uYyTd";
		
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$answer = json_decode($check);
		
		if ($answer->success==false)
		{
			$OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_password1'] = $password1;
		$_SESSION['fr_password2'] = $password2;
		if (isset($_POST['rules'])) $_SESSION['fr_rules'] = true;
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				
				if (!$result) throw new Exception($connection->error);
				
				$email_count = $result->num_rows;
				if($email_count>0)
				{
					$OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$result = $connection->query("SELECT id FROM users WHERE user='$nick'");
				
				if (!$result) throw new Exception($connection->error);
				
				$nick_count = $result->num_rows;
				if($nick_count>0)
				{
					$OK=false;
					$_SESSION['e_nick']="Istnieje już uzytkownik o takim nicku! Wybierz inny.";
				}
				
				if ($OK==true)
				{
					//Wszystkie testy zaliczone, dodajemy uzytkownika do bazy
					
					if ($connection->query("INSERT INTO users (access, user, pass, email, premiumExpirationDate) VALUES ('user', '$nick', '$password_hash', '$email', now())"))
					{
						$user_id = $connection->insert_id;

						//Dodanie potrfela przypisanego do uzytkownika do bazy

						if ($connection->query("INSERT INTO wallets (user_id) VALUES ('$user_id')")) {
							$wallet_id = $connection->insert_id;

							//Aktualizacja użytkownika o ID portfela

							if ($connection->query("UPDATE users SET wallet_id = '$wallet_id' WHERE id = '$user_id'")) {

						$_SESSION['successfull_registration']=true;
						header('Location: welcome.php');

							} else {

								throw new Exception($connection->error);

							}

						} else {

							throw new Exception($connection->error);

						}
					}
					else
					{
						throw new Exception($connection->error);
					}
					
				}
				
				$connection->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	
	<form method="POST">
	
		Nickname: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>" name="nick" /><br />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
		
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		Twoje hasło: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['fr_password1']))
			{
				echo $_SESSION['fr_password1'];
				unset($_SESSION['fr_password1']);
			}
		?>" name="password1" /><br />
		
		<?php
			if (isset($_SESSION['e_password']))
			{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
			}
		?>		
		
		Powtórz hasło: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_password2']))
			{
				echo $_SESSION['fr_password2'];
				unset($_SESSION['fr_password2']);
			}
		?>" name="password2" /><br />
		
		<label>
			<input type="checkbox" name="rules" <?php
			if (isset($_SESSION['fr_rules']))
			{
				echo "checked";
				unset($_SESSION['fr_rules']);
			}
				?>/> Akceptuję rules
		</label>
		
		<?php
			if (isset($_SESSION['e_rules']))
			{
				echo '<div class="error">'.$_SESSION['e_rules'].'</div>';
				unset($_SESSION['e_rules']);
			}
		?>	
		
		<div class="g-recaptcha" data-sitekey="6Le75SQmAAAAAODMcVX5bJwA2z6ko-h0bs4LfJTn"></div>
		
		<?php
			if (isset($_SESSION['e_bot']))
			{
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
			}
		?>	
		
		<br />
		
		<input type="submit" value="Zarejestruj się" />

		<p>[ <a href="../Ksiazki/index.php">Powrót</a> ]</p>
		
	</form>

</body>
</html>