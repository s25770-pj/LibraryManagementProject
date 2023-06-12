<?php
session_start();

if (isset($_SESSION['logged'])){
    header("Location: ../index.php");
    die;
}

require_once '../Config/config.php';
require_once '../Repository/login_repo.php';

    $db = new Database('localhost', 'root', '', 'blog');
    $LoginRepository = new LoginRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($LoginRepository->login($username, $password)) {
        header("Location:". $page);
        die();
    } else {
        $error = "Nieprawidłowy login lub hasło";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Log in screen</title>
    <link rel="stylesheet" href="<?php echo $login_css?>">
</head>
<body>
    <div id="login_box">
        <h2>Login</h2>
        <form method='POST' id="login_form"> 
            <div class="user_box">
            <input type="text" name="username" required><br />
            <label>Username</label>
            </div>
            <div class="user_box">
            <input type="password" name="password" required><br />
            <label>Password</label>
            </div>
            <a href="" onclick="document.getElementById('login_form').submit(); return false;">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Login
            </a>
        </form>
    </div>
    <?php
    echo $username;
    echo $password;
    if (isset($error)):?>
    <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>