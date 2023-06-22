<?php 

require_once '../Includes/path.php';

session_start();

if (isset($_SESSION['login']))
	{
		header('Location: '.$page);
		exit();
	}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <style>
        body {
            background-color: rgb(40, 40, 40);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .login-form {
            width: 15%;
            padding: 20px;
            background-color: rgb(60, 60, 60);
            border: 1px solid rgb(90, 90, 90);
        }
        
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            padding-right: 0;
            margin-bottom: 10px;
            border: 1px solid rgb(90, 90, 90);
            background-color: rgb(80, 80, 80);
            color: #fff;
        }
        
        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: rgb(90, 90, 90);
            border: none;
            color: #fff;
            cursor: pointer;
            border: 1px transparent solid;
        }
        .login-form input[type="submit"]:hover {
            border: 1px white solid;
        }
        
        .login-form p {
            text-align: center;
            margin-top: 10px;
        }
        
        .login-form a {
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="login-form">
        <form action="<?php echo $login ?>" method="POST">
        
            Login: <br />
            <input type="text" name="login" /> <br />
            Hasło: <br />
            <input type="password" name="password" /> <br /><br />

            <input type="submit" value="Zaloguj się" />

        </form>

        <?php
        echo '<p>[ <a href='. $page .'>Powrót</a> ]</p>';
        ?>
    </div>

</body>
</html>
