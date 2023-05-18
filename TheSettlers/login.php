<?php

if(session_start()==false){
session_start();
}

if(!isset(($_POST['login'])) || (!isset($_POST['password'])))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if($connection->connect_errno!=0)
{
    echo "Error: ".$connection->connect_errno ." Description: ".$connection->connect_error;
} 
else 
{

$login = $_POST['login'];
$password = $_POST['password'];

$login = htmlentities($login, ENT_QUOTES, "UTF-8");


if($result = @$connection->query(
    sprintf("SELECT * FROM uzytkownicy WHERE user ='%s'",
    mysqli_real_escape_string($connection, $login))))
{
    $how_many_users = @$result->num_rows;
    if($how_many_users > 0)
    {
        $row = $result->fetch_assoc();
        
        if(password_verify($password, $row['pass']))
        {
        $_SESSION['logged'] = true;

        
        $_SESSION['id'] = $row['id'];
        $_SESSION['user'] = $row['user'];
        $_SESSION['drewno'] = $row['drewno'];
        $_SESSION['kamien'] = $row['kamien'];
        $_SESSION['zboze'] = $row['zboze'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['dnipremium'] = $row['dnipremium'];

        unset($_SESSION['error']);
        $result->free_result();
        header('Location: game.php');
        } 
        else 
        {

            $_SESSION['error'] = '<span style="color:red"> Wrong login or password!</span></div>';
            Header('Location: index.php');
    
        }
        
    } else {

        $_SESSION['error'] = '<span style="color:red"> Wrong login or password!</span></div>';
        Header('Location: index.php');

    }
}

$connection->close();
}

?>