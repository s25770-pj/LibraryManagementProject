<?php

session_start();

if(!isset($_SESSION['logged']))
{
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

echo "<p>Hello ". $_SESSION['user'].'![<a href="logout.php">Wyloguj się!</a>]</p>';
echo "<p><b>Wood</b>:".$_SESSION['drewno'];
echo "| <b>Stone</b>:".$_SESSION['kamien'];
echo "| <b>Careal</b>:".$_SESSION['zboze']."</p>";

echo "<p><b>E-mail</b>: ".$_SESSION['email'];
echo "<br /><b>Days Premium</b>: ".$_SESSION['dnipremium']."</p>";
// echo session_id();

?>
    
</body>
</html>