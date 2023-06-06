<?php
session_start();

require_once '../Config/config.php';
require_once '../Repository/loginRepo.php';

    $db = new Database('localhost', 'root', '', 'blog');
    $loginRepository = new loginRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($loginRepository->login($username, $password)) {
        header("Location: $index");
        exit();
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
</head>
<body>
    <form method='POST'> 
        <input type="text" name="username"><br />
        <input type="password" name="password"><br />
        <button type="submit" name="login">Log in</button>
    </form>

    <a href="<?php echo $register_page; ?>" class="button">Register</a>

    <?php
    if (isset($error)):?>
    <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>