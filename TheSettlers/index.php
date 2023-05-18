<?php 

session_start();


if((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true))
{
    header('Location: game.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Settlers</title>
    <style>
        body {
            background-color: burlywood;
            overflow: hidden;
        }

        input {
            background-color: aqua;
            font-family: 'Courier New', Courier, monospace;
        }

        span {
            text-shadow: 1px 1px 1px red;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        a {
            text-decoration: none;
            color: blue;
            font-weight: bold;
            text-shadow: 2px 2px 1px white;
        }

        .login_screen {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 50vh;
            margin-bottom: 5%;
        }

        .sign_in {
            display: flex;
            justify-content: center;
            height: 40vh;
        }

    </style>

</head>
<body>


    <div class='login_screen'>
<form action='login.php' method='POST'>

Login: <br /><input type='text' name='login'><br><br>
Password: <br /><input type='password' name='password'><br><br>
<input type='submit' value='log in'>


</form>
    </div>
<div class='sign_in'>
    <a href = register.php> Registration - create your free acount!</a>
    </div>

<?php
// echo session_id();
if(isset($_SESSION['error']))
{
echo $_SESSION['error'];
}
?>
    
</body>
</html>