<?php
require_once '../Includes/path.php';
session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>

	<meta charset="utf-8" />
	<title>Księgarnia internetowa</title>
    <script src="../JS/browser.js"></script>
	<link rel="stylesheet" href="<?php echo $page_css; ?>">

</head>

<body>

    <?php
    require_once $database;
    require_once $header;
    ?>

    <header>
        <?php require_once $header; ?>
    </header>

    <main>
        <section class="searching"></section>
        <section id="bookResults"></section>

        <?php
        if (isset($_SESSION['login'])) {
            $connection->close();
        }
        ?>

        <br><br>

        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
        }
        ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Twoja Firma. Wszelkie prawa zastrzeżone.</p>
    </footer>

    <script src="../JS/script.js"></script>
</body>
</html>