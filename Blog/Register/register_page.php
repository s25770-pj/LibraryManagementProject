<?php
session_start();

if (isset($_SESSION['logged'])){
    header("Location: ../blog.php");
    die;
}

require_once '../Config/config.php';
require_once '../Repository/register_repo.php';

$RegisterRepository = new RegisterRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $second_password = $_POST['second_password'];
    $email = $_POST['email'];

    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['second_password'] = $second_password;
    $_SESSION['email'] = $email;

    if (empty($username) || empty($password) || empty($second_password) || empty($email)) {
        $_SESSION['error'] = "Wszystkie pola są wymagane";

    } else {

        if (ctype_alnum($username)==false)
		{
            $_SESSION['username_err'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}

        if (strlen($username) < 6 || strlen($username) > 30) {
            $_SESSION['username_err'] = "Login musi składać się z 6 do 30 znaków";
        }   
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_err'] = "Podany email jest nieprawidłowy";
        }

        if (strlen($password) < 6 || strlen($password) > 30) {
            $_SESSION['password_err'] = "Hasło musi składać się z 6 do 30 znaków";
        }

        if ($password != $second_password) {
            $_SESSION['password_err'] = "Hasła nie są takie same";
        }
    }

    if (empty($_SESSION['error']) && empty($_SESSION['username_err']) && empty($_SESSION['email_err']) && empty($_SESSION['password_err'])) {
        if ($RegisterRepository->register($username, $hash_password, $email)) {
            session_destroy();
            header("Location: $login_page");
        } else {
            $_SESSION['error'] = "Wystąpił błąd podczas rejestracji. Spróbuj ponownie później.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>

<?php 
if(isset($_SESSION['error'])) {
    echo '<span class="error">' . $_SESSION['error'] . '</span><br>';
} else {
    echo '<br>';
}
?>

<form method="POST">
    <input type="text" name="username" value="<?php if (isset($_SESSION['username'])) {
        echo $_SESSION['username'];
    } ?>" placeholder="Username"><br>

    <?php 
    if(isset($_SESSION['username_err'])) {
        echo '<span class="error">' . $_SESSION['username_err'] . '</span><br>';
    } else {
        echo '<br>';
    }
    ?>

    <input type="text" name="email" value="<?php if (isset($_SESSION['email'])) {
        echo $_SESSION['email'];
    } ?>" placeholder="Email"><br />

    <?php 
    if(isset($_SESSION['email_err'])) {
        echo '<span class="error">' . $_SESSION['email_err'] . '</span><br>';
    } else {
        echo '<br>';
    }
    ?>

    <input type="password" name="password" value="<?php if (isset($_SESSION['password'])) {
        echo $_SESSION['password'];
    } ?>" placeholder="Password"><br /><br />



    <input type="password" name="second_password" value="<?php if (isset($_SESSION['second_password'])) {
        echo $_SESSION['second_password'];
    } ?>" placeholder="Repeat password"><br />

    <?php 
    if(isset($_SESSION['password_err'])) {
        echo '<span class="error">' . $_SESSION['password_err'] . '</span><br>';
    } else {
        echo '<br>';
    }
    session_destroy();
    ?>

    <button type="submit" name="register">Register</button>
</form>
</body>
</html>